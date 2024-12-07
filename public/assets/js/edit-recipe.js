document.addEventListener('DOMContentLoaded', function () {
    const editRecipeForm = document.getElementById('editRecipeForm');

    editRecipeForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.text-danger.small').forEach(el => el.remove());

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                const successText = document.createElement('div');
                successText.className = 'alert alert-success text-center';
                successText.textContent = result.message;
                event.target.parentNode.prepend(successText);

                setTimeout(() => successText.remove(), 2000);
            } else if (result.errors) {
                for (const field in result.errors) {
                    const fieldElement = document.getElementById(field);

                    if (fieldElement) {
                        fieldElement.classList.add('is-invalid');
                        const errorText = document.createElement('div');
                        errorText.className = 'text-danger small';
                        errorText.textContent = result.errors[field];
                        fieldElement.parentNode.appendChild(errorText);
                    }
                }
            }

        } catch (error) {
            console.error('Произошла ошибка при сохранении рецепта: ', error);
        }
    });
});
