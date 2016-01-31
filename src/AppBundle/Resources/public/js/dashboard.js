/**
 * Created by alexst on 15.11.15.
 */
$(document).ready(function(){
    $('#rating_subdivisionbundle_cathedra_managers').multiselect({
        maxHeight: 200,
        numberDisplayed: 20,
        onDropdownShown: function(even) {
            this.$filter.find('.multiselect-search').focus();
        },
        enableCaseInsensitiveFiltering: true });

    $('#rating_subdivisionbundle_institute_managers').multiselect({
        maxHeight: 200,
        numberDisplayed: 20,
        onDropdownShown: function(even) {
            this.$filter.find('.multiselect-search').focus();
        },
        enableCaseInsensitiveFiltering: true });
});