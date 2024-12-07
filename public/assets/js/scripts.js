document.addEventListener('DOMContentLoaded', function () {
    const createRecipeForm = document.getElementById('createRecipeForm');
    const editRecipeForm = document.getElementById('editRecipeForm');
    const deleteButton = document.getElementById('deleteButton');

    if (createRecipeForm) {
        // Генерация слага для рецепта по заголовку
        function transliterate(str) {
            const map = {
                'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo', 'Ж': 'Zh', 'З': 'Z', 'И': 'I', 'Й': 'I', 'К': 'K', 'Л': 'L', 'М': 'M', 'Н': 'N', 'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U', 'Ф': 'F', 'Х': 'Kh', 'Ц': 'Ts', 'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sch', 'Ы': 'Y', 'Э': 'E', 'Ю': 'Yu', 'Я': 'Ya',
                'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'i', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'sch', 'ы': 'y', 'э': 'e', 'ю': 'yu', 'я': 'ya',
                ' ': '-', 'à': 'a', 'á': 'a', 'â': 'a', 'ã': 'a', 'ä': 'a', 'å': 'a', 'æ': 'ae', 'ç': 'c', 'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e', 'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i', 'ð': 'd', 'ò': 'o', 'ó': 'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ø': 'o', 'ù': 'u', 'ú': 'u', 'û': 'u', 'ü': 'u', 'ý': 'y', 'ÿ': 'y'
            };

            return str.split('').map(function(char) {
                return map[char] || char;
            }).join('');
        }

        function cleanSlug(slug) {
            return slug.toLowerCase()
                .replace(/[^a-z0-9-]/g, '')
                .replace(/-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        }

        document.getElementById('title').addEventListener('input', function () {
            const title = this.value;
            const slug = transliterate(title);

            document.getElementById('slug').value = cleanSlug(slug);
        });

        // Отправка формы
        document.getElementById('createRecipeForm').addEventListener('submit', async function (event) {
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

                if (response.ok && result.message) {
                    displaySuccessMessage(result.message, event.target.parentNode);
                } else if (result.errors) {
                    displayErrors(result.errors);
                }

            } catch (error) {
                console.error('Произошла ошибка при сохранении рецепта: ', error);
            }
        });
    }

    if (editRecipeForm) {
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
                   displaySuccessMessage(result.message, event.target.parentNode);
               } else if (result.errors) {
                   displayErrors(result.errors);
               }

           } catch (error) {
               console.error('Произошла ошибка при сохранении рецепта: ', error);
           }
        });
    }

    // Отображение ошибок
    function displayErrors(errors) {
        for (const field in errors) {
            const fieldElement = document.getElementById(field);

            if (fieldElement) {
                fieldElement.classList.add('is-invalid');
                const errorText = document.createElement('div');
                errorText.className = 'text-danger small';
                errorText.textContent = errors[field];
                fieldElement.parentNode.appendChild(errorText);
            }
        }
    }

    // Отображение успешного сообщения
    function displaySuccessMessage(message, targetElement) {
        const successText = document.createElement('div');
        successText.className = 'alert alert-success text-center';
        successText.textContent = message;
        targetElement.prepend(successText);

        setTimeout(() => successText.remove(), 5000);
    }

    if (deleteButton) {
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

                    setTimeout(() => window.location.href = '/', 2000);
                }

            } catch (error) {
                console.error('Ошибка при удалении рецепта: ', error);
            }
        });
    }
});
