document.addEventListener('DOMContentLoaded', function () {
    const deleteButton = document.getElementById('deleteButton');

    deleteButton.addEventListener('click', async function() {
        try {
            const response = await fetch(`/recipe/${recipeSlug}/delete`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });

            const result = await response.json();

            if (response.ok && result.message) {
                const successText = document.createElement('div');
                successText.className = 'alert alert-success text-center';
                successText.textContent = result.message;
                document.querySelector('#deleteModal .modal-body').prepend(successText);

                setTimeout(() => window.location.href = '/', 1000);
            }

        } catch (error) {
            console.error('Ошибка при удалении рецепта: ', error);
        }
    });
});