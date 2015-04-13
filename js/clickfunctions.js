$(document).ready(function() {
    $.getJSON('./results.json', function(data) {
        $.each(data, function(index, element) {
            var myndir = $('#myndastad').clone().attr('id', element['id']);
            myndir.children('#original_info').remove();
            myndir.find('.rank').html(element['todojob']);
            myndir.find('.title').html(element['username']);
            $('ol').append(myndir);
        });
        $('li').each(function(index,element) {
        var titill = $(this).find('.title');
          var aud = this.id;
          $(titill).click(function() {
            $.getJSON('./results.json', function(data) {
              var myndir = $('#original_info').clone().attr('id', 'cloned_info');
              myndir.find('.ar').html(data.username);
              myndir.find('.land').html(data.user_responsible);
              myndir.find('.flokkur').html(data.date);
              $('#cloned_info').remove();
              myndir.appendTo('#' + aud);
    });
});

});
        var mor = JSON.parse(window.localStorage.getItem('mor')) || [];
        if (mor.length != 0) {
            for (var i in mor) {
                $('#' + mor[i]).prop('checked', true);
            }
        }
        $('.clicked input').click(function() {
            var aud = this.id;
            if ($(this).is(':checked')) {
                mor.push(aud);
            } else {
                mor.splice($.inArray(aud, mor), 1);
            }
            window.localStorage.setItem('mor', JSON.stringify(mor));
        });
    });
});        