var Controller = {
    Post: function(_url,_data){
        return $.ajax({
            url: _url,
            type: 'POST',
            data: _data,
            dataType: 'json',
            cache: false,
        })
    },
    Get: function(_url,_data){
        return $.ajax({
            url: _url,
            type: 'GET',
            data: _data,
            dataType: 'json',
            cache: false
        })
    }
}