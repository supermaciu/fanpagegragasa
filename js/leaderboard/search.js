$(document).ready(() => {
    $("#searchbar").keyup(() => {
        load_data();

        function load_data(query) {
            $.ajax({
                url: "includes/leaderboard-search-inc.php",
                method: "POST",
                data: {
                    query : query
                },
                success: function(data) {
                    $('#result').html(data);
                }
            });
        }

        $('#searchbar').keyup(function(){
            var search = $(this).val();

            if(search != '') {
                load_data(search);
            } else {
                load_data();
            }
        });
    });
});