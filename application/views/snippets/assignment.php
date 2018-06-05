<div class="panel panel-default">
    <div class="panel-body">
        <select name="snippet_assignment_select" id="snippet_assignment_select">
            <option>-- Assign proses ke orang lain --</option>
            <option value="0">Assign ke orag ini</option>
        </select>
        <button type="button" id="snippet_assignment_button" class="main_button color6 small_btn">Assign</button>
    </div>
</div>

<script>
    $("#snippet_assignment_button").click(function() {
        $.ajax({
            url: $("#base-url").val() + 'Procurement/assign',
            type: 'post',
            dataType: 'json',
            data: {
                ptm: $("#ptm_number").val(),
                assign: $("#snippet_assignment_select").val(),
            },
        })
        .done(function(data) {
            console.log("success");
            console.log(data);
        })
        .fail(function(data) {
            console.log("error");
            console.log(data);
        })
    });
</script>