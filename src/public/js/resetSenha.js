// Mostrar/ocultar senha
  function toggleVisibility(btnId, inputId) {
    const btn = document.getElementById(btnId);
    const input = document.getElementById(inputId);

    btn.addEventListener('click', () => {
      const isPwd = input.type === 'password';
      input.type = isPwd ? 'text' : 'password';
      btn.querySelector('i').className = isPwd ? 'bi bi-eye-slash' : 'bi bi-eye';
    });
  }

  toggleVisibility('togglePass', 'password');
  toggleVisibility('togglePass2', 'password_confirmation');
