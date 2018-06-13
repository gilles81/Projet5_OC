/* Java script for ingredients list in select2*/


$(function() {
    $('#NewRecipeIngredient').select2(
        {
            placeholder: 'Selection d\'un ingredient',

        });
/** this part is for a next developppemnt
 *  it will be used to select 2 List ingredient
 */
/*
    $('#NewRecipeIngredient').select2(
        {
           // placeholder: 'Selection d\'un ingredient',
            ajax: {
                type: 'post',
                url: 'adminSearchComputeList.html',
                data :{'dishId': $('#NewRecipeIngredientIdHidden').val()},
                dataType: 'json'
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        });
*/
});






