$(document).ready( function () {
    if ($('#search_table')) {
        $('#search_table').DataTable({
            initComplete: function () {
                this.api().columns().every( function (index) {
                    var column = this;
                    // Only show drop down for some fields
                    if (index == 3 || index == 4) {
                    
                        var select = $('<select><option value="">Select Option</option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
        
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );
        
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    }
                } );
            }
        });
        $('.dataTables_length').addClass('bs-select');
    }

    if ($('#search_history_table')) {
        $('#search_history_table').DataTable();
    }
    
    if ($('#search_icon')) {
        $('#search_icon').click(function(e) {
            e.preventDefault();
            $("#form_search").submit();
        });
    }
});
