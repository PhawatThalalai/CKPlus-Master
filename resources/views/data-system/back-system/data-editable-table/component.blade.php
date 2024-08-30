<style>
    .table-container {
        position: relative;
        height: 60vh; /* Adjust the height as needed */
        overflow-y: auto;
    }
    .table-container thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }
    .form-control:focus {
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg);
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
    }

    .cell-editable {
        /* position: relative; */
        /* vertical-align: middle; /* Vertically center the content */
    }

    .edit-container {
        position: absolute;
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .editable-striped-table tbody tr:nth-of-type(odd) {
        background-color: #e3f2fd; /* สีฟ้าอ่อนมาก */
    }
    .editable-striped-table tbody tr:nth-of-type(even) {
        background-color: #fffde7; /* สีเหลืองอ่อนมาก */
    }
    .editable-striped-table tbody tr:nth-of-type(odd):hover {
        background-color: #bbdefb; /* สีฟ้าเข้มขึ้นเมื่อ hover */
    }
    .editable-striped-table tbody tr:nth-of-type(even):hover {
        background-color: #fff9c4; /* สีเหลืองเข้มขึ้นเมื่อ hover */
    }
    .editable-table tbody tr td {
        cursor: pointer;
    }
    .editable-table tbody tr td:hover {
        background-color: #bfffbf
    }

    /* Dark mode styles */
    [data-layout-mode="dark"] .editable-striped-table tbody tr:nth-of-type(odd) {
        background-color: #263238; /* สีเทาเข้ม */
    }
    [data-layout-mode="dark"] .editable-striped-table tbody tr:nth-of-type(even) {
        background-color: #4f4b37; /* สีเทาเข้มขึ้น */
    }
    [data-layout-mode="dark"] .editable-striped-table tbody tr:nth-of-type(odd):hover {
        background-color: #37474f; /* สีเทาเข้มขึ้นเมื่อ hover */
    }
    [data-layout-mode="dark"] .editable-striped-table tbody tr:nth-of-type(even):hover {
        background-color: #646445; /* สีเทาเข้มขึ้นเมื่อ hover */
    }
    [data-layout-mode="dark"] .editable-table tbody tr td:hover {
        background-color: #5f7a54; /* สีเทาเข้มสำหรับ hover */
    }

</style>


<h4>Table: {{ $tableName }}</h4>
<div class="table-container bg-light">

    <table class="table table-sm font-size-16 table-bordered border-primary editable-table editable-striped-table">
        <thead class="table-dark text-center">
            <tr>
                @foreach ($columns as $column)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr data-id="{{ $row->id }}"> <!-- Add data-id attribute to row -->
                    @foreach ($columns as $index => $column)
                        @if ($index === 0)
                            <th class="text-center">{{ $row->$column }}</th>
                        @else
                            <td class="cell-editable " data-column="{{ $column }}">{{ $row->$column }}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</div>


<!-- สคริปต์สำหรับกดที่ cell แล้วจะกลายเป็น input แก้ไข-->
<script>
    $(document).ready(function(){
        let editingCell = null; // To track the currently editing cell

        $('.cell-editable').on('click', function(){
            if (editingCell !== null) {
                // If there's an editing cell, remove the edit container and reset the cell
                editingCell.html(editingCell.data('originalValue'));
                editingCell = null;
            }

            var currentElement = $(this);
            editingCell = currentElement; // Set the current element as the editing cell

            var currentValue = currentElement.text();
            currentElement.data('originalValue', currentValue); // Store original value

            var currentValue = currentElement.text();
            var originalWidth = currentElement.width(); // Get the original width of the cell
            var originalHeight = currentElement.height(); // Get the original height of the cell
            var columnName = currentElement.data('column'); // Get the column name
            var rowId = currentElement.closest('tr').data('id'); // Get the row ID

            var inputElement = $('<input>', {
                type: 'text',
                value: currentValue,
                class: 'cell-editable-input form-control me-1',
                keyup: function(e) {
                    if (e.which === 13) { // Enter key
                        saveChanges();
                    }
                }
            }).css({
                'width': originalWidth + 'px', // Set the width of the input to match the original cell
                'height': originalHeight + 'px' // Set the height of the input to match the original cell
            });

            var saveButton = $('<button>', {
                type: 'button',
                class: 'btn btn-sm btn-success me-1',
                html: '<i class="fas fa-save"></i>',
                click: function(event) {
                    event.stopPropagation(); // Stop event propagation
                    saveChanges();
                }
            });

            var cancelButton = $('<button>', {
                type: 'button',
                class: 'btn btn-sm btn-danger',
                html: '<i class="fas fa-times"></i>',
                click: function(event) {
                    event.stopPropagation(); // Stop event propagation
                    removeEditContainer(false);
                }
            });

            var spinner = $('<div>', {
                class: 'spinner-border spinner-border-sm',
                role: 'status'
            }).css({
                '--bs-spinner-width': '1.5rem',
                '--bs-spinner-height': '1.5rem'
            }).append($('<span>', {
                class: 'visually-hidden',
                text: 'Loading...'
            }));

            spinner.hide();

            var editContainer = $('<div>', {
                class: 'edit-container'
            }).append(inputElement, saveButton, cancelButton);

            currentElement.html(editContainer);
            inputElement.focus().select(); // Focus and select the text

            function saveChanges() {
                var newValue = inputElement.val();
                if (newValue === currentValue) {
                    removeEditContainer(true); // If value is the same, do not send AJAX request
                    return;
                }

                editContainer.hide(); // Hide the edit container
                currentElement.append(spinner); // Show the spinner
                spinner.show(); // Show the spinner

                $.ajax({
                    url: "{{ route('dataStatic.update',0) }}",
                    method: 'POST',
                    data: {
                        _method: 'PUT',
                        update: 'editable-table',
                        table: '{{ $tableName }}',
                        id: rowId,
                        column: columnName,
                        value: newValue,
                        _token: '{{ csrf_token() }}' // Laravel CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            currentElement.text(newValue);
                            spinner.remove(); // Remove the spinner
                            editingCell = null; // Reset the editing cell
                            //-----------------
                            $(".toast-success").toast({
                                delay: 2000
                            }).toast("show");
                            $(".toast-success .toast-body .text-body").text("บันทึกสำเร็จ!");
                            //-----------------
                        } else {

                            $(".toast-error").toast({
                                delay: 5000
                            }).toast("show");
                            $(".toast-error .toast-body .text-body").text('การบันทึกล้มเหลว!');

                            spinner.remove(); // Remove the spinner
                            editContainer.show(); // Show the edit container

                            //alert('Failed to update the cell');
                            //removeEditContainer(false);
                        }
                    },
                    error: function() {
                        $(".toast-error").toast({
                                delay: 5000
                            }).toast("show");
                        $(".toast-error .toast-body .text-body").text('เกิดข้อผิดพลาดในการบันทึก กรุณาลองอีกครั้ง');

                        spinner.remove(); // Remove the spinner
                        editContainer.show(); // Show the edit container

                        //alert('Error occurred while updating the cell');
                        //removeEditContainer(false);
                    }
                });
            }

            function removeEditContainer(save) {
                if (save) {
                    var newValue = inputElement.val();
                    currentElement.text(newValue);
                } else {
                    currentElement.text(currentValue);
                }
                editContainer.remove(); // Remove the edit container
                editingCell = null; // Reset the editing cell
            }
        });


        /*
        $('.cell-editable').click(function(){
            var currentElement = $(this);

            // ตรวจสอบว่าช่องนี้กำลังแก้ไขอยู่หรือไม่
            if (currentElement.find('input').length > 0) {
                return; // ถ้ากำลังแก้ไขอยู่ให้หยุดการทำงาน
            }

            var currentValue = currentElement.text();
            var originalWidth = currentElement.width(); // Get the original width of the cell
            var originalHeight = currentElement.height(); // Get the original height of the cell

            var inputElement = $('<input>', {
                class: 'cell-editable-input form-control',
                type: 'text',
                value: currentValue,
                blur: function() {
                    var newValue = $(this).val();
                    currentElement.text(newValue);
                    currentElement.show();
                },
                keyup: function(e) {
                    if (e.which === 13) { // Enter key
                        $(this).blur();
                    }
                }
            }).css({
                'position': 'absolute',
                'width': originalWidth + 'px', // Set the width of the input to match the original cell
                'height': originalHeight + 'px' // Set the height of the input to match the original cell
            });

            currentElement.html(inputElement);
            inputElement.focus().select();

            //inputElement[0].setSelectionRange(currentValue.length, currentValue.length);
        });
        */
    });
</script>
