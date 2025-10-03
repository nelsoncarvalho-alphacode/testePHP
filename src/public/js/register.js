  const pwd = document.getElementById('password');
  const pwd2 = document.getElementById('password_confirmation');
  const t1 = document.getElementById('togglePass');
  const t2 = document.getElementById('togglePass2');
  const strengthEl = document.getElementById('pwdStrength');

  function toggle(btn, input){
    btn.addEventListener('click', () => {
      const isPwd = input.type === 'password';
      input.type = isPwd ? 'text' : 'password';
      btn.querySelector('i').className = isPwd ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
  }
  toggle(t1, pwd);
  toggle(t2, pwd2);

  // Força de senha (simples)
  function strength(s){
    let score = 0;
    if(!s) return '—';
    if(s.length >= 8) score++;
    if(/[A-Z]/.test(s)) score++;
    if(/[a-z]/.test(s)) score++;
    if(/[0-9]/.test(s)) score++;
    if(/[^A-Za-z0-9]/.test(s)) score++;
    return ['Fraca','Fraca','Média','Boa','Forte','Muito forte'][score];
  }
  pwd.addEventListener('input', () => strengthEl.textContent = strength(pwd.value));
