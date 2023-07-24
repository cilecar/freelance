<script setup>

</script>


<template>
    <div class="w-max m-auto">
        <div class="grid gap-5 mt-20">
            <input class="text-field__input" type="text" id="Task" placeholder="Название заказа" autocomplete="off">
            <input class="text-field__input" type="text" id="Description" placeholder="Описание заказа" autocomplete="off">
            <input class="text-field__input" type="text" id="Sphere" placeholder="Сфера деятельности" autocomplete="off">
            <input class="text-field__input" type="number" id="Budget" placeholder="Бюджет в рублях" autocomplete="off">
        </div>
        <div class="m-auto w-max mt-6">
            <button class="py-2 px-3 bg-white text-black rounded-md">
                Подтвердить
            </button>
        </div>
    </div>
</template>


<style>
.text-field__label {
    display: block;
    margin-bottom: 0.25rem;
}

.text-field__input {
    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    font-family: inherit;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #bdbdbd;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.text-field__input:focus {
    color: #212529;
    background-color: #fff;
    border-color: #bdbdbd;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(158, 158, 158, 0.25);
}
</style>


<script>

</script>