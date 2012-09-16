function ls_parse_data()
{
    var _addr =  '';

    $("tr[class^='server']").each(function() {
        serv_addr   = $(this).data('server-address');
        
        $.getJSON(RN_URL+"servers/fetch/"+ serv_addr +"/", function(data) {            
            _addr   = data.request;
            _holder = "tr.server[data-server-address='"+ _addr +"']";
            
            if (data.error != 'none')
            {
                $(_holder +' td#map').html('offline');
                $(_holder +' td#players').html('-');
                $(_holder +' td#ping').html('-');
            }
            else
            {
                $(_holder +' td#map').html( data.details.map )
                if (data.details.bots > 0)
                {
                    $(_holder +' td#players').html( 
                    '<a href="#show-players">'+ data.details.players_on +'/'+ data.details.players_max +' ('+ data.details.bots +' bots) </a>' )
                }
                else
                {
                    $(_holder +' td#players a').html( data.details.players_on +'/'+ data.details.players_max )
                }
                $(_holder +' td#ping').html( data.details.ping +" ms");
                
                // append online players
                var _parent = $("tr.players[data-server-address='"+ _addr +"'] table tbody");
                
                if (data.players.length == 0)
                {
                    _parent.html('<tr><td colspan="7" class="center">No players online.</td></tr>');
                }
                else
                {
                    $.each(data.players, function(i, item) {
                       _parent.append('<tr><td colspan="5">'+ item.nick +'</td> <td class="center">'+ item.score +'</td> <td class="center">'+ item.time_gmt +'</td></tr>');
                    });
                }
                
            }
                        
        })
        .error(function() {
            $("tr[data-server-address='"+ _addr +"'] td#map").html('connection error');
            $("tr[data-server-address='"+ _addr +"'] td#players").html('-');
            $("tr[data-server-address='"+ _addr +"'] td#ping").html('-');
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

function waitForJquery(){
  if(typeof window.jQuery == "undefined"){
    window.setTimeout(waitForJquery,50);
  }
  else{
    ls_parse_data();
  }
}

waitForJquery();