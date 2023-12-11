$(document).ready(function () {

    $('#departamento').change(function () {
        var departamentoId = $(this).val();

        if (departamentoId !== '') {
            $.ajax({
                url: '../../modelo/ubigeo.php',
                type: 'GET',
                data: {
                    departamento_id: departamentoId
                },
                dataType: 'json',
                success: function (data) {
                    $('#provincia').empty().prop('disabled', false);

                    $.each(data, function (index, provincia) {
                        $('#provincia').append('<option value="' + provincia.name + '">' + provincia.name + '</option>');
                    });
                },
                error: function () {
                    console.log('Error al cargar las provincias');
                }
            });
        } else {
            $('#provincia').empty().prop('disabled', true);
        }
    });

    $('#tipoDocumento').change(function () {
        var tipoDocumento = $(this).val();

        if (tipoDocumento === 'dni') {
            $('#numdoc').attr('maxlength', '8');
        } else {
            $('#numdoc').attr('maxlength', '12');
        }
    });
});