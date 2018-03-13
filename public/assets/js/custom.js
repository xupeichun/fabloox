
    $('.theRoles').on('click',function () {

        $('.theRoles').prop("checked", false);
        $(this).prop("checked", true);
    })
    function validateUrl(url) {
        var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
        console.log((url.match(p)) ? true : false);
        return (url.match(p)) ? true : false;
    }




