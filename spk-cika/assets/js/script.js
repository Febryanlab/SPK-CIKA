function toggleSidebar(){
  document.getElementById('sidebar').classList.toggle('open');
}

// Auto close sidebar di mobile setelah klik menu
document.querySelectorAll('.sidebar a').forEach(a => {
  a.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
      document.getElementById('sidebar').classList.remove('open');
    }
  });
});

// Auto dismiss alert success setelah 3 detik
setTimeout(() => {
  const alert = document.querySelector('.alert-success');
  if (alert) {
    alert.style.transition = 'opacity .5s';
    alert.style.opacity = '0';
    setTimeout(() => alert.remove(), 500);
  }
}, 3000);