</div>
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-4 mt-auto">
        <div class="border-top border-primary border-4 mb-4"></div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4 mb-3 mb-md-0">
                    <h6 class="mb-2 fw-bold text-dark">Links Rápidos</h6>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="<?= $root_path ?? '' ?>index.php" class="text-decoration-none text-muted small hover-link">
                            <i class="bi bi-house"></i> Dashboard
                        </a>
                        <a href="<?= $root_path ?? '' ?>views/clientes/index.php" class="text-decoration-none text-muted small hover-link">
                            <i class="bi bi-people"></i> Clientes
                        </a>
                        <a href="<?= $root_path ?? '' ?>views/produtos/index.php" class="text-decoration-none text-muted small hover-link">
                            <i class="bi bi-box"></i> Produtos
                        </a>
                        <a href="<?= $root_path ?? '' ?>views/pedidos/index.php" class="text-decoration-none text-muted small hover-link">
                            <i class="bi bi-cart"></i> Pedidos
                        </a>
                    </div>
                </div>
                <div class="col-md-5 col-lg-4">
                    <h6 class="mb-2 fw-bold text-dark">Suporte</h6>
                    <p class="text-muted small mb-1">
                        <a href="mailto:suporte@pedify.com" class="text-decoration-none text-muted hover-link">
                            <i class="bi bi-envelope text-primary"></i> suporte@pedify.com
                        </a>
                    </p>
                    <p class="text-muted small mb-0">
                        <a href="https://api.whatsapp.com/send?phone=5511999999999&text=Olá, preciso de suporte com o sistema Pedify!" 
                           target="_blank" 
                           class="text-decoration-none text-muted hover-link">
                            <i class="bi bi-whatsapp text-success"></i> (11) 9999-9999
                        </a>
                    </p>
                </div>
            </div>
            <hr class="my-3 border-primary opacity-25">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0 text-muted small">
                        &copy; <?= date('Y') ?> Pedify. Todos os direitos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts Globais -->
    <script>
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Tem certeza que deseja excluir este item?')) {
                    e.preventDefault();
                }
            });
        });

        const deleteMultipleBtn = document.getElementById('deleteMultiple');
        if (deleteMultipleBtn) {
            deleteMultipleBtn.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.select-item:checked');
                if (checkboxes.length === 0) {
                    alert('Selecione pelo menos um item para excluir.');
                    return;
                }
                if (confirm(`Tem certeza que deseja excluir ${checkboxes.length} item(ns)?`)) {
                    const form = document.getElementById('formDeleteMultiple');
                    form.submit();
                }
            });
        }

        const selectAll = document.getElementById('selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.select-item').forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateDeleteButton();
            });
        }

        document.querySelectorAll('.select-item').forEach(checkbox => {
            checkbox.addEventListener('change', updateDeleteButton);
        });

        function updateDeleteButton() {
            const deleteBtn = document.getElementById('deleteMultiple');
            if (deleteBtn) {
                const checkedCount = document.querySelectorAll('.select-item:checked').length;
                if (checkedCount > 0) {
                    deleteBtn.disabled = false;
                    deleteBtn.innerHTML = `<i class="bi bi-trash"></i> Excluir selecionados (${checkedCount})`;
                } else {
                    deleteBtn.disabled = true;
                    deleteBtn.innerHTML = '<i class="bi bi-trash"></i> Excluir selecionados';
                }
            }
        }

        document.querySelectorAll('.alert:not(.alert-permanent)').forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        (function() {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        function showLoading() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) {
                overlay.classList.add('show');
            }
        }

        function hideLoading() {
            const overlay = document.getElementById('loadingOverlay');
            if (overlay) {
                overlay.classList.remove('show');
            }
        }

        document.querySelectorAll('form').forEach(form => {
            if (!form.classList.contains('no-loading')) {
                form.addEventListener('submit', function() {
                    showLoading();
                });
            }
        });

        // Tooltips Bootstrap
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        // Popovers Bootstrap
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

        function formatarCPF(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                input.value = value;
            }
        }

        function formatarTelefone(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
                input.value = value;
            }
        }

        function formatarCEP(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length <= 8) {
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
                input.value = value;
            }
        }

        function formatarMoeda(input) {
            let value = input.value.replace(/\D/g, '');
            value = (parseFloat(value) / 100).toFixed(2);
            input.value = value;
        }

        document.querySelectorAll('input[data-mask="cpf"]').forEach(input => {
            input.addEventListener('input', () => formatarCPF(input));
        });

        document.querySelectorAll('input[data-mask="telefone"]').forEach(input => {
            input.addEventListener('input', () => formatarTelefone(input));
        });

        document.querySelectorAll('input[data-mask="cep"]').forEach(input => {
            input.addEventListener('input', () => formatarCEP(input));
        });

        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    setTimeout(() => {
                        submitBtn.disabled = false;
                    }, 3000);
                }
            });
        });

        // Scroll to top button
        window.addEventListener('scroll', function() {
            const scrollBtn = document.getElementById('scrollToTop');
            if (scrollBtn) {
                if (window.pageYOffset > 300) {
                    scrollBtn.style.display = 'block';
                } else {
                    scrollBtn.style.display = 'none';
                }
            }
        });

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        document.querySelectorAll('.hover-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.color = '#0d6efd';
                this.style.transform = 'translateY(-2px)';
            });
            link.addEventListener('mouseleave', function() {
                this.style.color = '';
                this.style.transform = '';
            });
        });
    </script>

    <!-- Botão Scroll to Top -->
    <button onclick="scrollToTop()" id="scrollToTop" 
            style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 99; 
                   border: none; outline: none; background-color: #0d6efd; color: white; 
                   cursor: pointer; padding: 15px; border-radius: 50%; font-size: 18px; 
                   box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: all 0.3s;"
            onmouseover="this.style.backgroundColor='#0b5ed7'"
            onmouseout="this.style.backgroundColor='#0d6efd'"
            title="Voltar ao topo">
        <i class="bi bi-arrow-up"></i>
    </button>

    <style>
        .hover-link {
            transition: all 0.3s ease;
            display: inline-block;
        }
    </style>
</body>
</html>