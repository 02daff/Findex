// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable0').DataTable();
});

$(document).ready(function() {
  $('#dataTable').DataTable({scrollY:'50vh'});
});

$(document).ready(function() {
  $('#dataTableMini').DataTable({scrollY:'30vh'});
});

$(document).ready(function() {
  $('#accordTable').DataTable( {
    "scrollX": true,
    "bInfo" :         false,
    lengthChange:     false,
    searching:        false, 
    paging:           false,
    fixedColumns:   {
        leftColumns: 1,
        rightColumns: 1
    },
    columnDefs: [ {
        orderable: false,
        className: 'select-checkbox',
        targets:   0
    } ],
    select: {
        style:    'multi+shift',
        selector: 'td:first-child'
    },
    order: [[ 1, 'asc' ]]
} );
} );

$(document).ready(function() {
  $('#accordTable1').DataTable( {
    "scrollX": true,
    "bInfo" :         false,
    lengthChange:     false,
    searching:        false, 
    paging:           false,
    fixedColumns:   {
        leftColumns: 1,
        rightColumns: 1
    },
    columnDefs: [ {
        orderable: false,
        className: 'select-checkbox',
        targets:   0
    } ],
    select: {
        style:    'multi+shift',
        selector: 'td:first-child'
    },
    order: [[ 1, 'asc' ]]
} );
} );