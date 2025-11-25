<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('closed');
  }
  
  // Additional scripts can be added here as needed
  @yield('scripts')
</script>