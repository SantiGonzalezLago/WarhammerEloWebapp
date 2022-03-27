/*!
  * WarhammerEloWebapp
  * Copyright (C) 2022 Santiago González Lago

  * This program is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.

  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.

  * You should have received a copy of the GNU General Public License
  * along with this program.  If not, see <https://www.gnu.org/licenses/>.
  */

$(function() {

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl, null)
    });

    $('select').selectpicker();

    $('#pwd-not-match').hide();

    $('div.in-use').hide();

    $('.pwd-register').on('keyup', function() {
      if ($('.pwd-register#password').val() != $('.pwd-register#repeat-password').val()) {
        $('#pwd-not-match').show();
      } else {
        $('#pwd-not-match').hide();
      }
    });

    $('#register-form').on('submit', function(e) {
      if ($('#register-form #password').val() != $('#register-form #repeat-password').val()) {
        e.preventDefault();
        $('#pwd-not-match').show();
      }
    });

    $('#reset-form').on('submit', function(e) {
      if ($('#register-form #password').val() != $('#register-form #repeat-password').val()) {
        e.preventDefault();
        $('#pwd-not-match').show();
      }
    });

    $('.setting-row input').on('change', function() {
       $(this).parent().parent().addClass('table-warning');
       $("#save-settings").attr("disabled", false);
    });

    $('#save-settings').on('click', function() {
        let changes = [];
        $('.setting-row.table-warning input').each(function() {
            let key = $(this).attr('id');
            let value;
            if ($(this).attr('type') == "checkbox") {
                value = $(this).is(':checked') ? 1 : 0;
            } else {
                value = $(this).val();
            }
            changes.push({key:key, value: value});
        });

        $.ajax({
            method: "POST",
            url: baseUrl + "/admin/saveSettingsAjax",
            dataType:'json',
            data: { settings: changes },
            success: function(data) {
                $('.setting-row.table-warning').removeClass('table-warning');
                $("#save-settings-modal").modal('show');
                $("#save-settings").attr("disabled", true);
            }  
        });
    });

    $('#change-display-name-modal form').on('submit', function(e) {
        e.preventDefault();
        let displayName = $('#change-display-name-modal #display-name').val();

        $.ajax({
            method: "POST",
            url: baseUrl + "/players/changeDisplayNameAjax",
            dataType:'json',
            data: { displayName: displayName },
            success: function(data) {
                if (data == 0) {
                    $('#display-name-used').show();
                } else {
                    location.reload();
                }
            }  
        });
    });

    $('#change-email-modal form').on('submit', function(e) {
        e.preventDefault();
        let email = $('#change-email-modal #email').val();

        $.ajax({
            method: "POST",
            url: baseUrl + "/players/changeEmailAjax",
            dataType:'json',
            data: { email: email },
            success: function(data) {
                if (data == 0) {
                    $('#email-used').show();
                } else {
                    location.reload();
                }
            }  
        });
    });

    $('#change-password-modal form').on('submit', function(e) {
        e.preventDefault();
        let password = $('#change-password-modal #password').val();
        let repeatPassword = $('#change-password-modal #repeat-password').val();
        if (password != repeatPassword) {
            return;
        }

        $.ajax({
            method: "POST",
            url: baseUrl + "/players/changePasswordAjax",
            dataType:'json',
            data: {
                password: password,
                repeatPassword: repeatPassword
            },
            success: function(data) {
                if (data == 0) {
                    $('#pwd-not-match').show();
                } else {
                    $("#change-password-modal").modal('hide');
                    $("#password-changed-modal").modal('show');
                }
            }  
        });
    });

    
    $('#change-description-modal form').on('submit', function(e) {
        e.preventDefault();
        let description = $('#change-description-modal #description').val();
        let id = $('#change-description-modal #id').val();

        $.ajax({
            method: "POST",
            url: baseUrl + "/games/changeDescriptionAjax",
            dataType:'json',
            data: {
                id: id,
                description: description
            },
            success: function() {
                location.reload();
            }
        });
    });

    if ($("#active-tab").length) {
        let activeTab = $("#active-tab").val();
        $("#" + activeTab  + "-tab").click();
    }

    $('#add-game-form').on('submit', function(e) {
        let p1 = $('#player1').val();
        let p2 = $('#player2').val();
        if (p1 == p2) e.preventDefault();
    });

});