<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyProjectController;
use App\Http\Controllers\StudentProjectController;
use App\Http\Controllers\CompanyApplicationController;
use App\Http\Controllers\DeliverableWorkflowController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ProjectApplicationController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\DeliverableController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\PortfolioItemController;
use App\Http\Controllers\CourseCompletionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Student\ApplicationController as StudentApplicationController;
use App\Http\Controllers\Student\PlacementController as StudentPlacementController;
use App\Http\Controllers\Student\DeliverableController as StudentDeliverableController;
use App\Http\Controllers\Student\CertificateController as StudentCertificateController;
use App\Http\Controllers\Student\PortfolioController as StudentPortfolioController;
use App\Http\Controllers\Student\CourseCompletionController as StudentCourseCompletionController;
use App\Http\Controllers\Student\PlacementRecommendationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Company side CRUD for projects
    Route::resource('company/projects', CompanyProjectController::class)->parameters([
        'projects' => 'project',
    ])->names('company.projects');

    // Student side: browse and apply/cancel
    Route::get('projects', [StudentProjectController::class, 'index'])->name('student.projects.index');
    Route::get('projects/browse', [StudentProjectController::class, 'browse'])->name('student.projects.browse');
    Route::get('projects/{project}/apply', [StudentProjectController::class, 'applyForm'])->name('student.projects.apply.form');
    Route::post('projects/{project}/apply', [StudentProjectController::class, 'apply'])->name('student.projects.apply');
    Route::delete('projects/{project}/apply', [StudentProjectController::class, 'cancel'])->name('student.projects.cancel');

    // Company side: manage applications and decide             
    Route::get('company/applications', [CompanyApplicationController::class, 'allApplications'])->name('company.applications.index');
    Route::get('company/projects/{project}/applications', [CompanyApplicationController::class, 'index'])->name('company.projects.applications.index');
    Route::post('company/projects/{project}/applications/{application}/decide', [CompanyApplicationController::class, 'decide'])->name('company.projects.applications.decide');
    Route::post('company/projects/{project}/auto-place', [CompanyApplicationController::class, 'autoPlace'])->name('company.projects.auto_place');
    Route::get('company/projects/{project}/placement', [CompanyApplicationController::class, 'placement'])->name('company.projects.placement');

    // Deliverable workflow
    Route::get('placements/{placement}/deliverables/create', [DeliverableWorkflowController::class, 'create'])->name('deliverables.create');
    Route::post('placements/{placement}/deliverables', [DeliverableWorkflowController::class, 'submit'])->name('deliverables.submit');
    Route::post('deliverables/{deliverable}/verify', [DeliverableWorkflowController::class, 'verify'])->name('deliverables.verify');

    // Student helper: my placement for a project
    Route::get('projects/{project}/my-placement', [StudentProjectController::class, 'myPlacement'])->name('student.projects.my_placement');

    // API Routes for CRUD operations
    // Projects CRUD
    Route::apiResource('api/projects', \App\Http\Controllers\ProjectController::class);

    // Companies CRUD
    Route::apiResource('api/companies', CompanyController::class);

    // Skills CRUD
    Route::apiResource('api/skills', SkillController::class);

    // Project Applications CRUD
    Route::apiResource('api/project-applications', ProjectApplicationController::class);

    // Placements CRUD
    Route::apiResource('api/placements', PlacementController::class);

    // Deliverables CRUD
    Route::apiResource('api/deliverables', DeliverableController::class);

    // Certificates CRUD
    Route::apiResource('api/certificates', CertificateController::class);

    // Portfolio Items CRUD
    Route::apiResource('api/portfolio-items', PortfolioItemController::class);

    // Course Completions CRUD
    Route::apiResource('api/course-completions', CourseCompletionController::class);

    // Notification Routes
    Route::get('notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');

    // Admin Routes
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        // Users CRUD
        Route::resource('users', UserController::class);

        // Skills CRUD
        Route::resource('skills', AdminSkillController::class);

        // Companies CRUD
        Route::resource('companies', AdminCompanyController::class);

        // UKM Requests CRUD
        Route::resource('ukm-requests', \App\Http\Controllers\Admin\UkmRequestController::class);

        // Projects Management
        Route::get('projects', [AdminProjectController::class, 'index'])->name('projects.index');
        Route::get('projects/{project}', [AdminProjectController::class, 'show'])->name('projects.show');
        Route::post('projects/{project}/approve', [AdminProjectController::class, 'approve'])->name('projects.approve');
        Route::post('projects/{project}/reject', [AdminProjectController::class, 'reject'])->name('projects.reject');
        Route::post('projects/{project}/publish', [AdminProjectController::class, 'publish'])->name('projects.publish');
    });

    // Student Routes
    Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
        // Applications
        Route::get('applications', [StudentApplicationController::class, 'index'])->name('applications.index');
        Route::get('applications/{application}', [StudentApplicationController::class, 'show'])->name('applications.show');

        // Placements
        Route::get('placements', [StudentPlacementController::class, 'index'])->name('placements.index');
        Route::get('placements/{placement}', [StudentPlacementController::class, 'show'])->name('placements.show');

        // Placement Recommendations
        Route::get('recommendations', [PlacementRecommendationController::class, 'index'])->name('recommendations.index');
        Route::get('api/recommendations', [PlacementRecommendationController::class, 'apiRecommendations'])->name('recommendations.api');

        // Deliverables
        Route::get('deliverables', [StudentDeliverableController::class, 'index'])->name('deliverables.index');
        Route::get('placements/{placement}/deliverables/create', [StudentDeliverableController::class, 'create'])->name('deliverables.create');
        Route::post('placements/{placement}/deliverables', [StudentDeliverableController::class, 'store'])->name('deliverables.store');
        Route::get('deliverables/{deliverable}', [StudentDeliverableController::class, 'show'])->name('deliverables.show');

        // Certificates
        Route::get('certificates', [StudentCertificateController::class, 'index'])->name('certificates.index');
        Route::get('certificates/{certificate}', [StudentCertificateController::class, 'show'])->name('certificates.show');

        // Portfolio
        Route::resource('portfolio', StudentPortfolioController::class)->parameters(['portfolio' => 'portfolioItem']);

        // Course Completions
        Route::resource('course-completions', StudentCourseCompletionController::class);

        // Internship Requests
        Route::resource('internship-requests', \App\Http\Controllers\Student\InternshipRequestController::class);
    });
});

Route::get('projects/{project}/download-brief', [CompanyProjectController::class, 'downloadBrief'])
    ->name('company.projects.download-brief');
Route::post('projects/{project}/close', [CompanyProjectController::class, 'close'])
    ->name('company.projects.close');

require __DIR__.'/auth.php';
