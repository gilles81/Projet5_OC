$(function() {
    /*
    $('#bt_eraser_receipe').click(function() {

        $(".bd-eraserReceipe-modal-lg").modal('show');
    });
    */
    $('#bt_loading_picturexx').click(function() {
        //$(".bd-eraserReceipe-modal-lg").modal('show');
        $.ajax({
            url : 'adminUpdateRecipePic.html',
            type : 'POST',
            data: {test : $("#customFile").val(), dishId : $("#customhiden").val() },

            success : function(code_html, statut){ console.log('succes')
                console.log('hiep');

            },
            error : function(resultat, statut, erreur){
                console.log('Nosucces')
            }
        });



    });



    $('#bt_loading_picture').click(function() {

        console.log(' #bt_loading ');


        /*
        $.ajax({
            url : 'adminNewPictureRecipeInDB.html',
            type : 'POST',
            data: {customhidden : $("#customhidden").val()  },
            success : function(code_html, statut){

                console.log('succes');
            },
            error : function(resultat, statut, erreur){
                console.log('Nosucces')
            }
        });
        */
        /*
        $.ajax({

            url : 'adminNewPictureRecipeInDB.html',
            type : 'FILE',
            data: {customFile : $("#customFile").val() },
            success : function(code_html, statut){

                console.log('succes');
            },
            error : function(resultat, statut, erreur){
                console.log('Nosucces')
            }
        });
*/


    });
});