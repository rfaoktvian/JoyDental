<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modalBody = document.getElementById('modalBody');
        const modalTitle = document.getElementById('modalTitle');
        const commonModal = new bootstrap.Modal(document.getElementById('commonModal'));

        window.loadModalContent = function(url, title) {
            modalBody.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border" role="status"></div>
                </div>
            `;
            modalTitle.textContent = title;

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error(
                        `Network response was not ok (${response.status})`);
                    return response.text();
                })
                .then(html => {
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = html;

                    const scripts = wrapper.querySelectorAll('script');
                    scripts.forEach(script => script.remove());

                    modalBody.innerHTML = wrapper.innerHTML;

                    scripts.forEach(script => {
                        const newScript = document.createElement('script');
                        if (script.src) {
                            newScript.src = script.src;
                            newScript.async = false;
                        } else {
                            newScript.textContent = script.textContent;
                        }
                        document.body.appendChild(newScript);
                    });
                })
                .catch(error => {
                    modalBody.innerHTML = `
                        <div class="alert alert-danger">Gagal memuat konten: ${error.message}</div>
                    `;
                });

            commonModal.show();
        };

        document.querySelectorAll('[data-modal-url]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.getAttribute('data-modal-url');
                const title = this.getAttribute('data-modal-title') || 'Detail';

                loadModalContent(url, title);
            });
        });
    });
</script>
