<div class="modal fade" id="videoLinks" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Video Links</h4>
                <h6 class="modal-title">Add videos to display on the brand detail page</h6>

            </div>
            <div class="modal-body">
                <form class=" form-horizontal">
                    <input type="hidden" name="product_id" required id="product_id_model">
                    <div class="form-group"><label class="col-lg-2 control-label">URL</label>
                        <div class="col-lg-8"><input class="form-control" maxlength="191" required="required"
                                                     autofocus="autofocus" placeholder="Enter URL" name="url[]"
                                                     type="url"></div>
                        <div class="col-lg-2"></div>
                    </div>
                    <div class="answers_contianer">

                    </div>
                    <div class="error_block">

                    </div>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="pull-right">
                                <a class="btn btn-warning btn-md add_ans">Add URL</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success saveUrl">Save</button>
            </div>
        </div>

    </div>
</div>

<script>
    $(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.access.brand.get") }}',
                type: 'post',
                data: {status: 1, trashed: false}
            },
            columns: [
                {data: 'DT_Row_Index', name: 'id'},
                {data: 'brandName', name: 'brandName'},
                {data: 'merchant_id', name: 'merchant_id'},
                {data: 'sort_no', name: 'sort_no'},
                {data: 'logo', name: 'logo'},
                {data: 'action', name: 'action', searchable: false, sortable: false}
            ],
            order: [[0, "asc"]],
            searchDelay: 500
        });
    });
    $(document).delegate(".deactivateButton", "click", function () {
        var id = $(this).data('id');
        console.log('sd')

        swal({
            title: 'Are you sure you want to deactivate?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }, function () {

            $.ajax({
                url: "{{ route("admin.access.brand.deactivateBrand") }}",
                data: {id: id},
                type: 'DELETE',


            }).done(function () {
                $('#cat-deactivate-' + id).closest('tr').remove();
            });
        })
    });
    $("table").delegate(".deleteButton", "click", function () {
        var id = $(this).data('id');


        swal({
            title: 'Are you sure you want to delete?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }, function () {

            $.ajax({
                url: "{{ url("admin/access/brand") }}/" + id,
                type: 'DELETE',


            }).done(function () {
                $('#cat-delete-' + id).closest('tr').remove();

            });
        })
    });

    $(document).delegate('.addLinks', 'click', function () {
        $('#product_id_model').val($(this).data('id'));
        $('.error_block').empty();
        $('.answers_contianer').empty();
        $('#videoLinks').modal('show')

    });
    $('.add_ans').on('click', function () {
        $('.answers_contianer').append(`<div class="form-group"><label  class="col-lg-2 control-label">URL</label><div class="col-lg-8"><input class="form-control theUrls"  required="required" autofocus="autofocus" placeholder="Enter URL" name="url[]" type="url"></div><div class="col-lg-2"><a class="btn btn-danger btn-md delete_btn">Delete</a> </div></div> `);
    });

    $('.answers_contianer').delegate('.delete_btn', 'click', function () {
        $(this).closest('.form-group').remove();
    });

    $('.saveUrl').on('click', function () {
        var urls = [];
        var influencer_id = $('#product_id_model').val();
        $('input[name^="url"]').each(function () {
            urls.push($(this).val());
        });
        var error=false;

        if (urls.length > 0) {
            $.each(urls, function (key,value) {
                if(validateUrl(value)){
                    error=false;
                }else{
                    $('.error_block').empty();
                    $('.error_block').append('<div class="col-lg-offset-2 col-lg-10"><label class="error_messages">Please Enter valid youtube URL<label></div>');
                    error=true;
                    return false;
                };
            })
        }
        if (urls.length > 0 && influencer_id != "" && error!= true) {
            $.post("{{route('admin.access.brand.add.links')}}", {
                'url[]': urls,
                'brand_id': influencer_id
            }).done(function (data) {
                console.log(data);
                if (data.status == 200) {
                    $('#videoLinks').modal('hide');
                    $('input[name^="url"]').val('');
                    $('.answers_contianer').empty();
                    swal({
                        text: 'Links added successfully!',
                        title: "Success!",
                        type: 'success'

                    },function () {
                        location.reload();
                    })
                } else if (data.status == 401) {

                    $('.error_block').empty();
                    $.each(data.data, function (key, data) {
                        $('.error_block').append('<div class="col-lg-offset-2 col-lg-10"><label class="error_messages">' + data + '<label></div>');

                    })
                }
            })
        }

    });


</script>