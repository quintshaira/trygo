function pagination_num_row(num_row)
{
    if(num_row=='A')
    {
        $("#page").val(1);
        $("#num_row").val(0);
    }
    else
    {
        $("#page").val(1);
        $("#num_row").val(num_row);
    }
    $("#search_form").submit();
}
function pagination(page_num)
{
    //alert('aa');
    if(page_num=='p')
    {
        $("#page").val($("#pagination_id1").val());
    }
    else if(page_num=='n')
    {
        $("#page").val(1);
        $("#num_row").val($("#pagination_id2").val());
    }
    else
    {
        if((page_num)*1)
        {
            $("#page").val(page_num);
        }
    }
    $("#search_form").submit();
}
function call_order(order_col,order_typ)
{
    $("#order_col").val(order_col);
    $("#order_typ").val(order_typ);
    $("#search_form").submit();
}
function do_quick_search(e, vall){
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code == 13) { //Enter keycode
        if(vall.trim())
        {
            $("#page").val(1);
        }

    }
}