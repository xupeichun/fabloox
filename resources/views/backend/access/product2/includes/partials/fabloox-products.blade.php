<div class="modal fade" id="videoLinks" role="dialog">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Video Links</h4>
                <h6 class="modal-title">Add links below for videos that you want to display with this product.</h6>

            </div>
            <div class="modal-body">
                <form class=" form-horizontal" id="productsVideos">
                    <input type="hidden" name="product_id" required id="product_id_model">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">URL</label>
                        <div class="col-lg-6"
                        ><input class="form-control" required="required"
                                autofocus="autofocus" placeholder="Enter URL" name="urls[]"
                                type="url"></div>
                        <div class="col-lg-2">
                            <input type="hidden" name="image" class="thumbnails" required data-imageid="0">
                        </div>
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
{{--============================gallery Products Model====================--}}
<div class="modal fade" id="gallery_product_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Image</h4>
                <h6 class="modal-title">Select an image for this product. When a user will click on this image from the
                    homepage, s/he will be taken directly to this product on the app.</h6>
            </div>
            <div class="modal-body">
                <form class=" form-horizontal">
                    <input type="hidden" name="product_id" required id="product_id_model">
                    @foreach($gallery as $gal)
                        <div class="form-group">
                            <div class="col-lg-10">
                                <img class="img-responsive" width="50" src="{{asset('/')}}{{$gal->image}}" alt="">
                            </div>
                            <div class="col-lg-2">
                                <input type="radio" name="checkbox_id" value="{{$gal->id}}"
                                       data-imgpath="{{$gal->image}}">
                            </div>
                        </div>

                    @endforeach
                    <div class="form-group">
                        <div class="error_block2"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button"
                        class="btn btn-success save_gallery_product" {{count($gallery)>0 ? '':'disabled' }}>Save
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        var images = [];
        var image_counter = 0;
        var query = {};
        var thePageNo;
        var pagination = $('#pagination-demo');
        search();
        $('.search_button').on('click', function () {
            pagination.twbsPagination('destroy');
            query = {};
            search();
        });

        function search() {

            $('#the_loader').show();
            var keyword = $('#keyword').val();
            var cat = $('#cat').val();
            /*var pageno=$('#pageno').val();*/
            var mid = $('#mid').val();
            var max = $('#max').val();
            var brand = $('#brand').val();

            if (keyword != "") {
                query.keyword = keyword;
            }
            if (cat != "") {
                query.cat = cat;
            }
            if (max != "") {
                query.itemsPerPage = max;
            }
            if (mid != "") {
                query.mid = mid;
            }

            if (brand != "") {
                query.thebrand = brand;
            }

            $.get("{{route('admin.ajax.get.products2')}}", query)
                .done(function (data) {
                    $('#the_loader').hide();
                    console.log(data);
                    $('.table_body').empty();
                    var result = data.data.products;
                    if (!$.isEmptyObject(data.data)) {
                        $.each(result, function (key, value) {
//                            if (result[key].isBlocked == false)
                            var theCheckValue = result[key].isBest ? "checked" : null;
                            var hasVideo = result[key].hasVideo ? '<a href="{{url("/admin/access/product/editlinks")}}/' + result[key].linkId + '" class="btn btn-xs btn-primary " ><i class="glyphicon glyphicon-edit "></i> Edit video links</a>' : "";
                            $('.table_body').append('<tr><td><img class="product_img" style="width:50px" src="' + result[key].image + '" alt=""></td><input type="hidden" class="product_merchantId" value="' + result[key].merchantId + '"><input type="hidden" class="product_sku" value="' + result[key].sku + '"><input type="hidden" class="product_primaryCat" value="' + result[key].categoryName + '"><input type="hidden" class="product_currency" value="' + result[key].currency + '"><input type="hidden" class="product_salepriceCurrency" value="' + result[key].salePriceCurrency + '"><input type="hidden" class="product_priceCurrency" value="' + result[key].priceCurrency + '"><input type="hidden" class="product_longDescription" value="' + result[key].longDescription + '"><input type="hidden" class="product_shortDescription" value="' + result[key].shortDescription + '"><input type="hidden" class="product_linkUrl" value="' + result[key].linkUrl + '"><td class="product_name">' + result[key].productName + '</td><td class="product_category">' + result[key].secondaryCategoryName + '</td><td class="salepriceCurrency">$' + result[key].salePriceCurrency + '</td><td class="merchant_name">' + result[key].merchantName + '</td><td><input type="checkbox" ' + theCheckValue + ' class="best_on_fabloox" data-id="' + result[key].linkId + '"></td><td><button class="btn btn-xs btn-success addLinks" data-id="' + result[key].linkId + '"><i class="glyphicon glyphicon-plus "></i> Add video links</button><button class="btn btn-xs btn-info add_gallery_products" data-id="' + result[key].linkId + '"><i class="glyphicon glyphicon-plus "></i> Add gallery product</button>' + hasVideo + ' <button  class="btn btn-xs btn-warning deactivateButton" data-id="' + result[key].linkId + '"><i class="glyphicon glyphicon-pause "></i> Deactivate</button></td></tr>');


                        });
//                    console.log(data.data.pageInfo.totalRecords/data.data.pageInfo.pageSize,Math.ceil(data.data.pageInfo.totalRecords/data.data.pageInfo.pageSize));

                        pagination.twbsPagination({
                            totalPages: Math.ceil(data.data.pageInfo.totalRecords/data.data.pageInfo.pageSize),
                            visiblePages: 7,
                            initiateStartPageClick: false,
                            hideOnlyOnePage: true,
                            onPageClick: function (event, page) {

                                console.log(page);
                                query.pagenumber = page;
                                $('#page-content').text('Page ' + page);
                                search();
                            }
                        });
                    }

                });
        }

        $(document).delegate(".deactivateButton", "click", function () {
            var button = $(this);
            var id = button.data('id');
            var image = button.closest('tr').find('.product_img').prop('src');
            var category = button.closest('tr').find('.product_category').text();
            var name = button.closest('tr').find('.product_name').text();
            var merchant = button.closest('tr').find('.merchant_name').text();

            console.log(id);
            swal({
                title: 'Are you sure you want to deactivate?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }, function () {

                $.ajax({
                    url: "{{ route("admin.access.product.deactivate") }}",
                    data: {
                        'product_id': id,
                        'name': name,
                        'image': image,
                        'category': category,
                        'merchant_name': merchant
                    },
                    type: 'POST',


                }).done(function () {
                    return 'deactivated'
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
            image_counter++;
            $('.answers_contianer').append(`<div class="form-group"><label  class="col-lg-2 control-label">URL</label><div class="col-lg-6"><input class="form-control theUrls"  required="required" autofocus="autofocus" placeholder="Enter URL" name="urls[]" type="url"></div><div class="col-lg-4"><input type="hidden" name="image" class="thumbnails"  data-imageid="` + image_counter + `" required></div><div class="col-lg-2"><a class="btn btn-danger btn-md delete_btn">Delete</a> </div></div> `);
        });

        $('.answers_contianer').delegate('.delete_btn', 'click', function () {
            var the_id = $(this).closest('.form-group').find('.thumbnails').data('imageid');
            delete images[the_id];
            $(this).closest('.form-group').remove();

        });

//        $(document).delegate(".thumbnails","change",function () {
//
//            var imgid=$(this).data('imageid');
//            images[imgid]=$(this)[0].files[0];
//            console.log(images);
//        });
        $('.saveUrl').on('click', function () {
            var urls = [];
//            var images=$('input[name="images[]"]');
            var p_id = $('#product_id_model').val();
            $('input[name^="urls"]').each(function () {
                urls.push($(this).val());
            });
            var error = false;

            if (urls.length > 0) {
                $.each(urls, function (key, value) {
                    if (validateUrl(value)) {
                        error = false;
                    } else {
                        $('.error_block').empty();
                        $('.error_block').append('<div class="col-lg-offset-2 col-lg-10"><label class="error_messages">Please Enter valid youtube URL<label></div>');
                        error = true;
                        return false;
                    }
                    ;
                })
            }


            if (urls.length > 0 && p_id != "" && error != true) {
                $.post("{{route('admin.access.product.add.links')}}", {
                    'url[]': urls,
                    link_id: p_id
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


        /*======================================Best on Fabloox=======================================*/
        //set initial state.
//        $('#textbox1').val($(this).is(':checked'));
        $(document).delegate('.best_on_fabloox', 'change', function () {
            var this_checkbox = $(this);
            var id = this_checkbox.data('id');
            var image = this_checkbox.closest('tr').find('.product_img').prop('src');
            var category = this_checkbox.closest('tr').find('.product_category').text();
            var name = this_checkbox.closest('tr').find('.product_name').text();
            var salepriceCurrency = this_checkbox.closest('tr').find('.product_salepriceCurrency').val();
            var merchant = this_checkbox.closest('tr').find('.merchant_name').text();

            var product_merchantId = this_checkbox.closest('tr').find('.product_merchantId').val();
            var product_sku = this_checkbox.closest('tr').find('.product_sku').val();
            var product_primaryCat = this_checkbox.closest('tr').find('.product_primaryCat').val();
            var product_currency = this_checkbox.closest('tr').find('.product_currency').val();
            var product_priceCurrency = this_checkbox.closest('tr').find('.product_priceCurrency').val();
            var product_longDescription = this_checkbox.closest('tr').find('.product_longDescription').val();
            var product_shortDescription = this_checkbox.closest('tr').find('.product_shortDescription').val();
            var product_linkUrl = this_checkbox.closest('tr').find('.product_linkUrl').val();

            if ($(this).is(':checked')) {
                swal({
                    title: 'Are you sure you want to add?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }, function (state) {
                    if (state == true) {
                        $.ajax({
                            url: "{{ route("admin.access.product.add.best") }}",
                            data: {
                                'product_id': id,
                                'name': name,
                                'image': image,
                                'category': category,
                                'merchant_name': merchant,
                                'merchantId': product_merchantId,
                                'sku': product_sku,
                                'categoryName': product_primaryCat,
                                'currency': product_currency,
                                'priceCurrency': product_priceCurrency,
                                'salePriceCurrency': salepriceCurrency,
                                'longDescription': product_longDescription,
                                'shortDescription': product_shortDescription,
                                'linkUrl': product_linkUrl,
                            },
                            type: 'POST',


                        }).done(function (data) {
                            if (data.status == 200) {
                                this_checkbox.prop('checked', true);
                            } else if (data.status == 401) {
                                this_checkbox.prop('checked', false);
                            } else if (data.status == 500) {
                                this_checkbox.prop('checked', false);
                            }
                        });
                    } else {
                        this_checkbox.prop('checked', false);
                    }
                })
            } else {

                swal({
                    title: 'Are you sure you want to delete?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }, function (state) {
                    if (state == true) {
                        $.ajax({
                            url: "{{ route("admin.access.product.remove.best") }}",
                            data: {
                                'id': id,
                            },
                            type: 'POST',


                        }).done(function (data) {
                            if (data.status == 200) {
                                this_checkbox.prop('checked', false);
                            } else if (data.status == 401) {
                                this_checkbox.prop('checked', true);
                            } else if (data.status == 500) {
                                this_checkbox.prop('checked', true);
                            }
                        });
                    } else {
                        this_checkbox.prop('checked', true);

                    }
                })
            }


        });
        /*========================= gallery products======================================*/
        var product_data = {};
        $(document).delegate('.add_gallery_products', 'click', function () {
            var this_checkbox = $(this);
            var id = this_checkbox.data('id');
            var image = this_checkbox.closest('tr').find('.product_img').prop('src');
            var category = this_checkbox.closest('tr').find('.product_category').text();
            var name = this_checkbox.closest('tr').find('.product_name').text();
            var salepriceCurrency = this_checkbox.closest('tr').find('.product_salepriceCurrency').val();
            var merchant = this_checkbox.closest('tr').find('.merchant_name').text();

            var product_merchantId = this_checkbox.closest('tr').find('.product_merchantId').val();
            var product_sku = this_checkbox.closest('tr').find('.product_sku').val();
            var product_primaryCat = this_checkbox.closest('tr').find('.product_primaryCat').val();
            var product_currency = this_checkbox.closest('tr').find('.product_currency').val();
            var product_priceCurrency = this_checkbox.closest('tr').find('.product_priceCurrency').val();
            var product_longDescription = this_checkbox.closest('tr').find('.product_longDescription').val();
            var product_shortDescription = this_checkbox.closest('tr').find('.product_shortDescription').val();
            var product_linkUrl = this_checkbox.closest('tr').find('.product_linkUrl').val();

            product_data = {
                'product_id': id,
                'name': name,
                'image': image,
                'category': category,
                'merchant_name': merchant,
                'merchantId': product_merchantId,
                'sku': product_sku,
                'categoryName': product_primaryCat,
                'currency': product_currency,
                'priceCurrency': product_priceCurrency,
                'salePriceCurrency': salepriceCurrency,
                'longDescription': product_longDescription,
                'shortDescription': product_shortDescription,
                'linkUrl': product_linkUrl
            };
            $('#gallery_product_modal').modal('show');
            $('.error_block2').empty();

        });


        $('.save_gallery_product').on('click', function () {

            var imgpath = $('input[name=checkbox_id]:checked').data('imgpath');
            var id = $('input[name=checkbox_id]:checked').val();
            $('.error_block2').empty();

            if (typeof(imgpath) != 'undefined' && typeof(id) != 'undefined' && imgpath != "" && id != "") {
                product_data.imagePath = imgpath;
                product_data.imgId = id;
                $.post("{{route('admin.access.product.add.gallery.products')}}", product_data).done(function (data) {
                    if (data.status == 200) {
                        $('input[name=checkbox_id]').prop('checked', false);
                        $('#gallery_product_modal').modal('hide');
                        $('.error_block2').empty();

                        swal({
                            text: 'Product link has been added to gallery image!',
                            title: "Success!",
                            type: 'success'

                        })
                    } else if (data.status == 401) {
                        $('.error_block2').empty();
                        $('.error_block2').append(`<div class="col-lg-offset-1 col-lg-10"><label class="error_messages">${data.data}<label></div>`);


                    }
                })
            } else {
                $('.error_block2').empty();
                $('.error_block2').append('<div class="col-lg-offset-1 col-lg-10"><label class="error_messages">Plaese select an image<label></div>');

            }

        });


    })
</script>