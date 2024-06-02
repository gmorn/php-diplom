@extends('welcome')
@section('title', 'Добавление товара')
@section('content')
    <div class="category-container">
        <h3 class="category-title">Категория</h3>
        <div class="category-block">
            <div class="chapters">
                @foreach ($chapters as $chapter)
                    <div class="chapter" onmouseover="showCategories('{{ $chapter->name }}', {{ $chapter->categories->toJson() }}, {{ $chapter->id }})">
                        <p>{{ $chapter->name }}</p>
                    </div>
                @endforeach
            </div>
            <div class="categories">
                <ul id="categories">
                    <li>Наведите на раздел, чтобы увидеть категории</li>
                </ul>
            </div>
        </div>
        <div id="selectedCategory"></div>
        <button id="cancelButton">Отмена</button>
        <form id="productForm" method="POST" action="{{ route('create_product_post') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="chapterId" id="chapterId" value="">
            <input type="hidden" name="categoryId" id="categoryId" value="">
            <h3 class="category-title">Параметры</h3>
            <div class="add-product-param-block">
                <div class="add-product-param">
                    <div class="add-product-param-title">Название объявления</div>
                    @component('components.main-input', ['placeholder' => 'Введите название товара', 'type' => 'text', 'name' => 'name']) @endcomponent
                </div>
                <div class="add-product-param">
                    <div class="add-product-param-title">Цену товара</div>
                    @component('components.main-input', ['placeholder' => 'Введите цену', 'type' => 'number', 'name' => 'price']) @endcomponent
                </div>
                <div class="add-product-param">
                    <div class="add-product-param-title">Адресс проведения сделки</div>
                    @component('components.main-input', ['placeholder' => 'Введите адрес', 'type' => 'text', 'name' => 'address']) @endcomponent
                </div>
                <div class="add-product-param">
                    <div class="add-product-param-title">Оисание объявления</div>
                    @component('components.main-input', ['placeholder' => 'Введите описание', 'textarea' => true, 'name' => 'description']) @endcomponent
                </div>
            </div>
            <div class="mb-3">
                <label for="gallery">Галерея изображений</label>
                <input type="file" class="form-control" id="gallery" name="gallery[]" multiple required accept="image/*">
            </div>
            <div class="mb-3">
                <label>Тип</label><br>
                <div class="toggle-button-group">
                    <input type="radio" name="type" id="new" value="0" checked>
                    <label for="new" class="toggle-button">Новое</label>
                    <input type="radio" name="type" id="used" value="1">
                    <label for="used" class="toggle-button">Б/У</label>
                </div>
            </div>
            <div class="mb-3">
                <label>Метод связи</label><br>
                <input type="radio" name="connectMethod" value="1" checked> Только чат
                <input type="radio" name="connectMethod" value="2"> Только телефон
                <input type="radio" name="connectMethod" value="3"> Оба
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection

<style>
    .category-container {
        box-shadow: inset 0 0 10px 0 rgba(0, 0, 0, 0.1);
        padding: 15px;
        margin-top: 15px;
        padding: 15px;
        border-radius: 12px;
    }
    .add-product-param {
        display: flex;
        width: 830px;
        justify-content: space-between;
    }
    .add-product-param input {
        width: 400px;
    }
    .add-product-param textarea {
        width: 400px;
        height: 200px;
    }
    .add-product-param-title {
        font-weight: 500;
        font-size: 14px;
        width: 250px;
        padding-top: 10px;
    }

    .toggle-button-group {
        display: flex;
        border: 1px solid #ccc;
        border-radius: 25px;
        overflow: hidden;
        width: fit-content;
    }

    .add-product-param-block {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .toggle-button-group input[type="radio"] {
        display: none;
    }

    .toggle-button {
        padding: 10px 20px;
        cursor: pointer;
        flex: 1;
        text-align: center;
        user-select: none;
    }

    .toggle-button-group input[type="radio"]:checked + .toggle-button {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 25px;
    }

    .toggle-button-group input[type="radio"]:not(:checked) + .toggle-button {
        background-color: #f7f7f7;
    }

    .toggle-button-group input[type="radio"]:checked + .toggle-button:first-of-type {
        border-radius: 25px 0 0 25px;
    }

    .toggle-button-group input[type="radio"]:checked + .toggle-button:last-of-type {
        border-radius: 0 25px 25px 0;
    }

    .toggle-button-group input[type="radio"]:checked + .toggle-button + input[type="radio"] + .toggle-button {
        border-left: none;
    }


    .category-title {
        margin-bottom: 25px;
    }


    .category-block {
        display: flex;
        width: 750px;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
        border-radius: 12px;
        overflow: hidden;
        height: 450px;
    }
    .chapters {
        flex: 1;
        margin-right: 20px;
    }
    .categories {
        flex: 1;
        padding-left: 20px;
    }
    .chapter {
        cursor: pointer;
        padding: 10px;
    }
    .chapter:hover {
        background-color: #f0f0f0;
    }
    .chapter p {
        font-weight: 500;
        font-size: 14px;
    }
    .chapter:hover p {
        background-color: #f0f0f0;
    }
    .categories ul {
        list-style: none;
        padding: 0;
    }
    .categories ul li {
        padding: 10px;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
    }
    .categories ul li:hover {
        background-color: #f0f0f0;
    }
    #selectedCategory {
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
    }
    #selectedCategory:hover {
        text-decoration: underline;
    }
    #cancelButton {
        display: none;
        margin-top: 10px;
        padding: 5px 10px;
        cursor: pointer;
    }
    #productForm {
        display: none;
        margin-top: 20px;
        width: 80%;
    }
</style>
<script>
    function showCategories(chapterName, categories, chapterId) {
        const categoriesContainer = document.getElementById('categories');
        categoriesContainer.innerHTML = '';
        categories.forEach(category => {
            const li = document.createElement('li');
            li.textContent = category.name;
            li.onclick = () => showSelectedCategory(chapterName, category.name, category.id, chapterId);
            categoriesContainer.appendChild(li);
        });
    }


    function showSelectedCategory(chapterName, categoryName, categoryId, chapterId) {
        const selectedCategory = document.getElementById('selectedCategory');
        selectedCategory.textContent = `${chapterName} / ${categoryName}`;
        document.getElementById('categoryId').value = categoryId;
        document.getElementById('chapterId').value = chapterId;
        toggleVisibility(false);
        showProductForm();
    }

    function toggleVisibility(show) {
        const container = document.querySelector('.category-block');
        container.style.display = show ? 'flex' : 'none';
        const cancelButton = document.getElementById('cancelButton');
        cancelButton.style.display = show ? 'block' : 'none';
    }

    function showProductForm() {
        const productForm = document.getElementById('productForm');
        productForm.style.display = 'block';
    }

    document.addEventListener('DOMContentLoaded', () => {
        const selectedCategory = document.getElementById('selectedCategory');
        selectedCategory.addEventListener('click', () => toggleVisibility(true));
        const cancelButton = document.getElementById('cancelButton');
        cancelButton.addEventListener('click', () => {
            toggleVisibility(true);
            document.getElementById('productForm').style.display = 'none';
        });
    });
</script>
