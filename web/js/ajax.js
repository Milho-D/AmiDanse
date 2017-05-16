$(document).ready(function() {


    $(".courant").click( function () {

        $.ajax({
            url: '/danses/ajax',
            type: 'POST',
            data:
                {
                    id : $(this)[0].id
                },
            dataType: 'json',
            success: function(reponse) {

                $("#contentModal").empty();
                $(".modal-title").empty();
                $(".modal-title").html(reponse[0].nomCourant);

                $.each(reponse, function(index, element) {

                    if (element.nomType === 'pas de type'){
                        $("#contentModal").append('<p>'+element.nomType+'</p>')
                    } else {

                        if (element.urlVideo === null){
                            $("#contentModal").append('<div class="col-md-4"><li style="list-style: none"><a href="/agenda">'+element.nomType+'</a></li></div>')
                        } else {
                            $("#contentModal").append('<div class="col-md-6"><li style="list-style: none; width: auto"><a href="/agenda">'+element.nomType+'</a></div>' +
                                '<div class="col-md-4"><button type="button" class="btn">' +
                                '<a data-fancybox href="'+element.urlVideo+'" type="video/mp4">Découvrir en vidéo !</a>' +
                                '</button>' +
                                '</div></li><hr>')
                        }
                    }

                });

                $("#myModal").modal();

            }
        });

    })

});