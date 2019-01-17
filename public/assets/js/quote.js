    $(document).ready(function() {
    var table = $('#table').DataTable( {
        "ajax": {
            "url": "quote/json",
            "dataSrc": ""
        },
        "columns": [
             {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "id" },
            { "data": "reference" },
            { "data": "ammount" },
            { "data": "created" },
            {
                "className":      'edit-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {
                "className":      'delete-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            
        ]
    } );
    
    // Add event listener for opening and closing details
    $('#table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
    
     // Add event listener for edit
    $('#table tbody').on('click', 'td.edit-control', function () {
        var tr = $(this).closest('tr');
        var data = table.row( tr ).data();
        var id=data['id'];
        
        var url ="quote/edit/"+id;
        $('.modal-container').load(url,function(result){
	 $('#myModal').modal({show:true});
	});
     } );
     
     $('#add').on('click', function () {
        var url ="quote/add";
        $('.modal-container').load(url,function(result){
	 $('#myModal').modal({show:true});
	});
     } );
    
    // Add event listener delete
    $('#table tbody').on('click', 'td.delete-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var data = row.data();
        
        if (confirm('Are you sure you want to delete: '+ data['reference'] )) {
       // Delete it!
       $.get( "quote/delete/"+data['id'], function( data ) {
         $( "#result" ).html( data );
          $("#table").DataTable().ajax.reload();
        });
       
        } else {
        // Do nothing!
        }
        
         
 
       
    } );
      
} );

function format ( d ) {
    // `d` is the original data object for the row
    return ''+d.description;
}