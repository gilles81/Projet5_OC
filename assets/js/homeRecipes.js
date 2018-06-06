$(function() {


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