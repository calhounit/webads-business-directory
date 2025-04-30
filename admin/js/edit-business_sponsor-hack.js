/**
 * Created by John on 9/11/2019.
 */

jQuery(document).ready(function(){

    // list businesses - hide slug column in table
    jQuery('.wp-list-table td:nth-child(4),.wp-list-table th:nth-child(4)').hide();
    //jQuery('.wp-list-table td:nth-child(5),.wp-list-table th:nth-child(5)').hide();

    // list businesses - hide view link
    jQuery('.row-actions .view, .row-actions .hide-if-no-js').hide();



});