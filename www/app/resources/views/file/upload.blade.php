@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Загрузка файла Excel</h2>
    <form id="uploadForm" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="excelFile">Выберите файл Excel</label>
            <input type="file" class="form-control-file" id="excelFile" name="excel_file">
        </div>
        <button class="btn btn-primary" id="uploadButton">Загрузить</button>
    </form>
</div>
<div>
    <table class="table table-bordered" id="loaded-rows">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
<script>
    // Выбираем элементы формы и кнопки
    const uploadForm = document.getElementById('uploadForm');
    const uploadButton = document.getElementById('uploadButton');

    // Добавляем обработчик события для кнопки, чтобы обрабатывать отправку формы
    uploadButton.addEventListener('click', function (event) {
        event.preventDefault();
        // Создаем объект FormData для сбора данных из формы
        const formData = new FormData(uploadForm);

        // Отправляем POST-запрос на сервер с помощью Axios
        window.axios.post('{{ route('upload') }}', formData, {
            headers: {
                'Content-Type': 'multipart/form-data', // Устанавливаем тип контента для загрузки файла
            },
        })
            .then(function (response) {
                uploadForm.reset();
                console.log(response.data); // Здесь вы можете выполнить дополнительную обработку ответа
            })
            .catch(function (error) {
                uploadForm.reset();
                console.error(error);
            });
    });
</script>
@endsection
