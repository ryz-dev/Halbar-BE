function selectImg(f, e) {
  $("#previewImage_-").attr("src", f);
  $("#targetValue_-").attr("value", e);
  $("#modal-galleries").modal("toggle");
}

function maxSelected() {
  jQuery(function() {
    var max = 5;
    var checkboxes = $('input[type="checkbox"]');
    checkboxes.change(function() {
      var current = checkboxes.filter(":checked").length;
      checkboxes.filter(":not(:checked)").prop("disabled", current >= max);
    });
  });
}

function changePreview(size) {
  $(".modal-title a").removeClass();
  $(".modal-title a").addClass("btn btn-default");
  if (size === "lg") {
    $("#link-device-lg").removeClass();
    $("#link-device-lg").addClass("btn btn-info");
    $("#modal-preview .modal-dialog").css({
      "max-width": "calc(100% - 50px)",
      width: "100%"
    });
  } else if (size === "md") {
    $("#link-device-md").removeClass();
    $("#link-device-md").addClass("btn btn-info");
    $("#modal-preview .modal-dialog").css({
      "max-width": "720px",
      width: "100%"
    });
  } else {
    $("#link-device-sm").removeClass();
    $("#link-device-sm").addClass("btn btn-info");
    $("#modal-preview .modal-dialog").css({
      "max-width": "360px",
      width: "100%"
    });
  }

  /*function loadFile(event) {
    var image = URL.createObjectURL(event.target.files[0]);
    localStorage.setItem("image", image);
  }*/
}

/* Swiper slider */

var swiper = new Swiper(".swiper-container", {
  slidesPerView: 3,
  spaceBetween: 30,
  slidesPerGroup: 3,
  loop: true,
  loopFillGroupWithBlank: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  }
});
