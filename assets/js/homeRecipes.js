$(function() {

    $( '#Bt_Search_Home').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'findInDb.html',
            timeout: 3000,
            data :{ 'SearchFormHome' : $('#SearchFormHome').val()},
           //data :{ SearchFormHome : $('#SearchFormHome').name()},
            beforeSend: function(){},
            success: function(data) {

                $('#secondPartHome').html(data); },
            error: function() {
                alert('La requête n\'a pas abouti'); }
        });

    });




        $('#cat1').click(function(e) {

            $.ajax({
                type: 'post',
                url: 'homeRecipesCat1.html',
                timeout: 3000,
                beforeSend: function(){},
                success: function(data) {
                  $('#secondPartHome').html(data); },
                error: function() {
                    alert('La requête n\'a pas abouti'); }
            });
        });
    $('#cat2').click(function(e) {

        $.ajax({
            type: 'post',
            url: 'homeRecipesCat2.html',
            timeout: 3000,
            beforeSend: function(){ },
            success: function(data) {
                $('#secondPartHome').html(data); },
            error: function() {
                alert('La requête n\'a pas abouti'); }
        });
    });
    $('#cat3').click(function(e) {

        $.ajax({
            type: 'post',
            url: 'homeRecipesCat3.html',
            timeout: 3000,
            beforeSend: function(){ },
            success: function(data) {
                $('#secondPartHome').html(data); },
            error: function() {
                alert('La requête n\'a pas abouti'); }
        });
    });
    $('#cat4').click(function(e) {

        $.ajax({
            type: 'post',
            url: 'homeRecipesCat4.html',
            timeout: 3000,
            beforeSend: function(){},
            success: function(data) {
                $('#secondPartHome').html(data); },
            error: function() {
                alert('La requête n\'a pas abouti'); }
        });
    });

    $( window ).ready(function() {
        // Run code

        $.ajax({
            type: 'post',
            url: 'homeRecipesCat4.html',
            timeout: 3000,
            beforeSend: function(){},
            success: function(data) {
                $('#secondPartHome').html(data); },
            error: function() {
                alert('La requête n\'a pas abouti'); }
        });

    });


});