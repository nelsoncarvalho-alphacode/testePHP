const pwd = document.getElementById('password');
  const toggle = document.getElementById('togglePass');
  toggle.addEventListener('click', () => {
    const isPwd = pwd.type === 'password';
    pwd.type = isPwd ? 'text' : 'password';
    toggle.querySelector('i').className = isPwd ? 'bi bi-eye-slash' : 'bi bi-eye';
  })
