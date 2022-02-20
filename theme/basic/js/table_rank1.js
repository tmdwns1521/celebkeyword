try{
  var myTable = document.getElementById( "relation_keys" );
  var replace = replacement( myTable );
  function sortTD( index ){    replace.ascending( index );    }
  function reverseTD( index ){    replace.descending( index );    }
}
catch(error){
  var s = 'wait';
}
