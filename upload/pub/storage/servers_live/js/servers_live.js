function ls_parse_data()
{
    var _addr = _holder = _parent = '';

    $("tr[class^='server']").each(function() {
        _addr   = $(this).data('server-address');
        
        $.ajax ({
            type: "GET",
            dataType: "json",
            request: _addr,
            timeout: 3000,
            url: RN_URL+"servers/fetch/"+ _addr +"/",
            success: function(data) {
                                
                _addr = data.request;
                _holder = "tr.server[data-server-address='"+ _addr +"']";
                
                if (data.error != 'none') {
                    show_error(_addr, data.error);
                    return;
                }
                
                $(_holder +' td#map').html( data.details.map )
                $(_holder +' td#players a').html( data.details.players_on +'/'+ data.details.players_max )
                $(_holder +' td#ping').html( data.details.ping +" ms");
                
                // show bots count
                if (data.details.bots > 0)
                {
                    $(_holder +' td#players').append('('+ data.details.bots +' bots)'); 
                }
                
                // online players
                _parent = $("tr.players[data-server-address='"+ _addr +"'] table tbody");
                
                // empty server
                if (data.players.length == 0)
                {
                    _parent.html('<tr><td colspan="7" class="center">No players online.</td></tr>');
                }
                {
                    // append each player
                    $.each(data.players, function(i, item) {
                        var _append = (item.is_bot) ? '(<em>bot</em>)' : '';
                        _parent.append('<tr><td colspan="5">'+ item.nick +' '+ _append +'</td> <td class="center">'+ item.score +'</td> <td class="center">'+ item.time_gmt +'</td></tr>');
                    });
                }
            },
            error: function(xhr, status, error) {
                show_error(this.request, error);
            }
        });
        
                
    });
    
    // unhide players table 
    $('td#players a').click(function(event) {
        event.preventDefault();

        var _server = $(this).parent().parent().data('server-address');    
        var _parent = $("tr.players[data-server-address='"+ _server +"']");
            
        if (_parent.hasClass('hide'))
        {
            _parent.removeClass('hide');
        }
        else
        {
            _parent.addClass('hide');
        } 
    });

}; 

function show_error(address, error)
{
    $("tr[data-server-address='"+ address +"'] td#map").html('-');
    $("tr[data-server-address='"+ address +"'] td#players a").html('-');
    $("tr[data-server-address='"+ address +"'] td#ping").html('-');
                
    $("tr.players[data-server-address='"+ address +"'] table tbody").html('<tr><td colspan="7" class="center">'+ error +'</td></tr>');
}

function waitForJquery() {
  if(typeof window.jQuery == "undefined"){
    window.setTimeout(waitForJquery,50);
  }
  else {
    ls_parse_data();
  }
}

waitForJquery(); 