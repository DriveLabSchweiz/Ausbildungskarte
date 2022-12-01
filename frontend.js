jQuery(document).ready(function() {
    let $ = jQuery;
    let table = $('.shop_table.shop_table_responsive.my_account_orders.my_account_appointments.past');
    $.each(table.find('tbody tr'), function() {
        $(this).find('td').eq(($(this).find('td').length-1)).append(
            '<a href="'+$(this).find('td').eq(0).find('a').attr('href')+'">Details</a>'
        );
    });
});
