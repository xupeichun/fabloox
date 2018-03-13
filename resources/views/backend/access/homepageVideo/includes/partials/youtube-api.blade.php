
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Channle List</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>

                    </tr>
                    </thead>
                    <tbody id="table_body">
                    </tbody>

                </table>
                <nav aria-label="Page navigation " class="paginate">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link prev_link" href="javascript:void(0)"
                                                 data-token="">Previous</a></li>
                        <li class="page-item"><a class="page-link next_link" href="javascript:void(0)"
                                                 data-token="">Next</a></li>
                    </ul>
                </nav>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<script>
    $(document).ready(function () {


        $('.channel_search , .prev_link , .next_link').on('click', function () {
            var keyword = $('#keyword').val();
            if ($(this).hasClass('channel_search')) {
                search(keyword,'');
            } else if ($(this).hasClass('prev_link')) {
                search(keyword, $('.prev_link').attr('data-token'));
            } else if ($(this).hasClass('next_link')) {
                search(keyword,$('.next_link').attr('data-token'));
            }

        });
        $('.cross').on('click', function () {

            $('#channel').val('');
            $('.para').hide();
            $(".channel_search").prop('disabled', false);
        });

        $(document).delegate('.addChannel','click',function () {
            $('#myModal').modal('hide')
            $(".channel_search").prop('disabled', true);
            $('input[name=keyword]').val('');
            var channelData=$(this);
            $('#channel').val(channelData.attr('id'));
            $('.para').show();
            $('.channleName').text(channelData.closest('tr').find('.channelTitle').text());
        });
        function search(keyword, pageToken) {


            $.get("https://www.googleapis.com/youtube/v3/search?",
                {
                    part: "snippet",
                    maxResults: "10",
                    q: keyword,
                    key: "{{env('GOOGLE_DEV_KEY')}}",
                    type: "channel",
                    pageToken: pageToken
                })
                .done(function (data) {
                    $('#table_body').empty();

                    var result = data.items
                    console.log(data)
                    $.each(result, function (key, value) {

                        $('#table_body').append('<tr><td><img style="width:40px "  src="' + result[key].snippet.thumbnails.medium.url + '" alt=""></td><td class="channelTitle">' + result[key].snippet.channelTitle + '</td><td>' + result[key].snippet.description + '</td><td><button id="'+result[key].id.channelId +'" class="btn btn-xs btn-success addChannel">Add</button></td></tr>')

                    });
                    var paginate = $('.paginate');

                    paginate.find('.next_link').attr('data-token', data.nextPageToken);

                    paginate.find('.prev_link').attr('data-token', data.prevPageToken);
                    $('#myModal').modal('show')
                });
        }


    })
</script>