jQuery(window).load(function () {
  const apiUrl = "https://preview.ninjateam.org/filebird/wp-json/filebird/v1/add";
  const TB_WIDTH = 520;
  const TB_HEIGHT = 320;
  var urlRedirect = '';
  let selected = 'Unselected', key = 'none';

  function callApi(key, feed) {
    $.ajax({
      method: "POST",
      contentType: "application/json",
      url: apiUrl,
      data: JSON.stringify({ key: key, feed: feed }),
      dataType: "json"
    })
      .done(function (res) {
        window.location.href = urlRedirect;
      })
      .fail(function (res) {
        console.log("Feedback can't submit");
        console.log(res.responseText);
        window.location.href = urlRedirect;
      });
  }

  document
    .querySelector('[data-slug="filebird"] a, [data-slug="filebird-lite"] a')
    .addEventListener("click", function (event) {
      event.preventDefault();
      urlRedirect = document
        .querySelector('[data-slug="filebird"] a, [data-slug="filebird-lite"] a')
        .getAttribute("href");
      tb_show(
        "Quick Feedback - FileBird",
        "#TB_inline?height=370&amp;width=490&amp;inlineId=filebird-feedback-window"
      );
      $("#TB_window").css({
        marginLeft: "-" + parseInt(TB_WIDTH / 2, 10) + "px",
        width: TB_WIDTH + "px",
        height: TB_HEIGHT + "px",
        marginTop: parseInt(($(window).height() - TB_HEIGHT) / 2, 10) + "px"
      });

      $(window).resize(function () {
        $("#TB_window").css({
          marginLeft: "-" + parseInt(TB_WIDTH / 2, 10) + "px",
          width: TB_WIDTH + "px",
          height: TB_HEIGHT + "px",
          marginTop: parseInt(($(window).height() - TB_HEIGHT) / 2, 10) + "px"
        });
      });

      $("#TB_ajaxContent input[type=radio]").on("change", function () {
        selected = $("input[name=reasons]:checked", "#TB_ajaxContent").val();
        key = $("input[name=reasons]:checked", "#TB_ajaxContent").attr("id");
        if (key === "other") {
          $("#feedback-suggest-plugin").hide();
          $("#feedback-description").show();
          $("#feedback-description").on("change", function () {
            selected = $("#feedback-description").val();
          });
          $("#TB_window").css({
            marginLeft: "-" + parseInt(TB_WIDTH / 2, 10) + "px",
            width: TB_WIDTH + "px",
            height: "400px"
          });
        }
        else if (key === 'found_better_plugin') {
          $("#feedback-description").hide();
          $("#feedback-suggest-plugin").show();
          $("#feedback-suggest-plugin").on("change", function () {
            selected = $("#feedback-suggest-plugin").val();
          })
          $("#TB_window").css({
            marginLeft: "-" + parseInt(TB_WIDTH / 2, 10) + "px",
            width: TB_WIDTH + "px",
            height: "360px"
          });
        }
        else {
          $("#feedback-description").hide();
          $("#feedback-suggest-plugin").hide();
          $("#TB_window").css({
            marginLeft: "-" + parseInt(TB_WIDTH / 2, 10) + "px",
            width: TB_WIDTH + "px",
            height: TB_HEIGHT + "px"
          });
        }
      });
      $("#feedback-submit").click(function () {
        callApi(key, selected);
      });
      $("#feedback-skip").click(function () {
        callApi('skip', 'skip');
      });
    });
});
