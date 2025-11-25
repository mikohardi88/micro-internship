<?php

namespace App\Services;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectApplication;
use App\Models\Placement;
use App\Models\StudentProfile;
use App\Models\Skill;
use App\Notifications\PlacementCreatedNotification;
use Illuminate\Support\Facades\DB;

class PlacementMatchingService
{
    /**
     * Automatically place students based on their applications and project requirements
     */
    public function processApplications(Project $project): ?Placement
    {
        // Get all pending applications for this project
        $applications = ProjectApplication::with(['user.studentProfile', 'user.skills'])
            ->where('project_id', $project->id)
            ->where('status', 'pending')
            ->get();

        if ($applications->isEmpty()) {
            return null;
        }

        // Score each application based on matching criteria
        $scoredApplications = $applications->map(function ($application) use ($project) {
            $score = $this->calculateMatchingScore($application->user, $project);
            return [
                'application' => $application,
                'score' => $score
            ];
        });

        // Get the best matching application
        $bestMatch = $scoredApplications->sortByDesc('score')->first();

        if (!$bestMatch || $bestMatch['score'] < 30) { // Minimum score threshold
            return null;
        }

        // Create placement for the best match
        return $this->createPlacement($bestMatch['application'], $project);
    }

    /**
     * Calculate matching score between student and project (0-100)
     */
    private function calculateMatchingScore(User $student, Project $project): int
    {
        $score = 0;
        $maxScore = 100;

        // Skills matching (40 points)
        $skillScore = $this->calculateSkillsMatch($student, $project);
        $score += $skillScore * 0.4;

        // Interest/Field matching (25 points)
        $interestScore = $this->calculateInterestMatch($student, $project);
        $score += $interestScore * 0.25;

        // Duration availability (20 points)
        $durationScore = $this->calculateDurationMatch($student, $project);
        $score += $durationScore * 0.2;

        // Education level/semester (15 points)
        $educationScore = $this->calculateEducationMatch($student, $project);
        $score += $educationScore * 0.15;

        return min(round($score), $maxScore);
    }

    /**
     * Calculate skills matching score
     */
    private function calculateSkillsMatch(User $student, Project $project): int
    {
        $studentSkills = $student->skills->pluck('id')->toArray();
        $projectSkills = $project->skills->pluck('id')->toArray();

        if (empty($projectSkills)) {
            return 50; // Neutral score if no specific skills required
        }

        $matchingSkills = array_intersect($studentSkills, $projectSkills);
        $matchPercentage = count($matchingSkills) / count($projectSkills);

        return $matchPercentage * 100;
    }

    /**
     * Calculate interest/field matching score
     */
    private function calculateInterestMatch(User $student, Project $project): int
    {
        $profile = $student->studentProfile;
        if (!$profile || !$profile->interests) {
            return 50;
        }

        $interests = strtolower($profile->interests);
        $projectTitle = strtolower($project->title);
        $projectDescription = strtolower($project->description);

        // Check if student interests match project keywords
        $interestKeywords = explode(',', $interests);
        $matchCount = 0;

        foreach ($interestKeywords as $keyword) {
            $keyword = trim($keyword);
            if (strpos($projectTitle, $keyword) !== false || strpos($projectDescription, $keyword) !== false) {
                $matchCount++;
            }
        }

        return $interestKeywords ? ($matchCount / count($interestKeywords)) * 100 : 50;
    }

    /**
     * Calculate duration availability match
     */
    private function calculateDurationMatch(User $student, Project $project): int
    {
        // For now, assume all students are available
        // In a real system, you'd check student's availability preferences
        return 100;
    }

    /**
     * Calculate education level match
     */
    private function calculateEducationMatch(User $student, Project $project): int
    {
        $profile = $student->studentProfile;
        if (!$profile) {
            return 50;
        }

        $semester = $profile->semester ?? 1;
        
        // Prefer students who are at least in 3rd semester
        if ($semester >= 3) {
            return 100;
        } elseif ($semester >= 2) {
            return 70;
        } else {
            return 40;
        }
    }

    /**
     * Create placement for accepted application
     */
    private function createPlacement(ProjectApplication $application, Project $project): Placement
    {
        return DB::transaction(function () use ($application, $project) {
            // Update application status
            $application->update([
                'status' => 'accepted',
                'decided_at' => now()
            ]);

            // Create placement
            $placement = Placement::create([
                'project_id' => $project->id,
                'user_id' => $application->user_id,
                'status' => 'matched',
                'started_at' => now(),
            ]);

            // Update project status
            $project->update(['status' => 'in_progress']);

            // Reject all other pending applications
            ProjectApplication::where('project_id', $project->id)
                ->where('status', 'pending')
                ->where('id', '!=', $application->id)
                ->update([
                    'status' => 'rejected',
                    'decided_at' => now(),
                    'decision_notes' => 'Project has been filled with a better matching candidate'
                ]);

            // Send notification to student about placement
            $application->user->notify(new PlacementCreatedNotification($placement));

            return $placement;
        });
    }

    /**
     * Get placement recommendations for a student
     */
    public function getRecommendationsForStudent(User $student, int $limit = 5): array
    {
        $availableProjects = Project::where('status', 'published')
            ->whereDoesntHave('placement')
            ->with(['skills', 'company'])
            ->get();

        $recommendations = $availableProjects->map(function ($project) use ($student) {
            $score = $this->calculateMatchingScore($student, $project);
            return [
                'project' => $project,
                'score' => $score,
                'reasons' => $this->getMatchingReasons($student, $project)
            ];
        })
        ->sortByDesc('score')
        ->take($limit)
        ->values();

        return $recommendations->toArray();
    }

    /**
     * Get reasons for matching score
     */
    private function getMatchingReasons(User $student, Project $project): array
    {
        $reasons = [];

        $skillScore = $this->calculateSkillsMatch($student, $project);
        if ($skillScore > 70) {
            $reasons[] = "Skills match well ({$skillScore}%)";
        }

        $interestScore = $this->calculateInterestMatch($student, $project);
        if ($interestScore > 70) {
            $reasons[] = "Interests align with project";
        }

        $educationScore = $this->calculateEducationMatch($student, $project);
        if ($educationScore > 70) {
            $reasons[] = "Education level suitable";
        }

        return $reasons;
    }
}
