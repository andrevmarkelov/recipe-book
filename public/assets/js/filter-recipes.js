document.addEventListener('DOMContentLoaded', function () {
    const recipeSearch = document.getElementById('recipeSearch');
    const recipeSort = document.getElementById('recipeSort');
    const recipesContainer = document.getElementById('recipesContainer');

    async function fetchRecipes() {
        const searchQuery = recipeSearch.value.trim();
        const sortOption = recipeSort.value;

        if (searchQuery.length > 0 && searchQuery.length < 3) {
            return;
        }

        const params = new URLSearchParams({
            search: searchQuery,
            sort: sortOption
        });

        try {
            const response = await fetch(`/recipes?${params.toString()}`);
            const result = await response.json();

            if (response.ok) {
                renderRecipes(result.recipes);
            } else {
                console.error('Произошла ошибка: ', response);
            }

        } catch (error) {
            console.error('Произошла ошибка: ', error);
        }
    }

    function renderRecipes(recipes) {
        if (recipes.length === 0) {
            recipesContainer.innerHTML = '<p class="text-center recipe-empty text-muted mt-5">Ничего не найдено.</p>';
            return;
        }

        recipesContainer.innerHTML = recipes.map(recipe => `
            <div class="col-sm-6 col-lg-4 col-xl-3 mb-4">
                <div class="recipe-item">
                    <a href="/recipe/${recipe.slug}" class="recipe-item__image">
                        <img src="/public/assets/images/recipe-images/${recipe.image_path}" alt="${recipe.title}">
                    </a>
                    <div class="recipe-item__content p-4">
                        <a href="/recipe/${recipe.slug}" class="h5 recipe-item__title">${recipe.title}</a>
                        <p class="recipe-item__instructions">${recipe.instructions}</p>
                        <a href="/recipe/${recipe.slug}" class="btn-default">Подробнее</a>
                    </div>
                </div>
            </div>
        `).join('');
    }

    recipeSearch.addEventListener('input', fetchRecipes);
    recipeSort.addEventListener('change', fetchRecipes);
});
