(function ($) {
  "use strict";

  var form = $("#contact-form");
  var formMessages = $("#form-messages");

  $(form).submit(function (e) {
    e.preventDefault();

    var submitBtn = $("#submit");
    submitBtn.prop("disabled", true);
    submitBtn.find(".btn-text").text("Sending...");

    var formData = $(form).serialize() + "&phone=" + $("#contact-phone").val();

    $.ajax({
      type: "POST",
      url: $(form).attr("action"),
      data: formData,
    })
      .done(function (response) {
        $(formMessages).removeClass("error").addClass("success").text(response);
        $(
          "#contact-name, #contact-email, #subject, #contact-message, #contact-phone",
        ).val("");

        // Disable form after successful submission
        $(form).find("input, textarea, button").prop("disabled", true);
        submitBtn.find(".btn-text").text("Message Sent");
      })
      .fail(function (data) {
        $(formMessages).removeClass("success").addClass("error");

        if (data.responseText !== "") {
          $(formMessages).text(data.responseText);
        } else {
          $(formMessages).text(
            "Oops! An error occurred and your message could not be sent.",
          );
        }

        // Re-enable button on failure
        submitBtn.prop("disabled", false);
        submitBtn.find(".btn-text").text("Contact Me");
      });
  });
})(jQuery);
