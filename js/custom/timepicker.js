let TimePicker = function(PRIMARY_COLOR="#00897b") {

  let settings = {};

  /* Angles used to calculate number positions */
  let valToDeg = [0, 60, 30, 0, 30, 60, 90, 60, 30, 0, 30, 60, 90];

  let visibleSteps = [];

  /* CLOCK RADIUS */
  let radius = 125 - 20;

  /* Flag set to true when the button row is hidden */
  let TP_NO_BUTTONS = false;

  /**
	 * Display the Time Picker
	 * @param input query object of the time input field
   * @param options
   */
  function show(input, options) {
    settings = $.extend({
        datetime : null,
        callback : function(dateTime){console.log(dateTime)},
        parent : input,
        step : null,
        min : null,
        max : null,
        readonly : false
      }, options);
    if (_setup()) {
			$('#timepicker').foundation('open');
    }
  }

  /**
   * Hide the Time Picker
   */
  function hide() {
    _hideClockFace();
		$('#timepicker').foundation('close');
  }

  /**
   * Initialize the clock and start the display of hours
   * @private
   */
  function _setup() {
    settings.step = parseInt(_getAttribute('step', settings.step));
    settings.stepMinutes = settings.step / 60;
    settings.min = _getSeconds(_getAttribute('min', settings.min));
    settings.max = _getSeconds(_getAttribute('max', settings.max));
    settings.readonly = settings.parent.attr('readonly') !== undefined;
    if (settings.datetime === null) {
      let value = settings.parent.attr('value');
			if (value === undefined || value == '') {
        value = '00:00:00';
			}
      settings.datetime = new Date('2000-01-01T' + value);
		}
    if (settings.readonly) {
      return false;
    }
    if (settings.datetime === null) {
      settings.datetime = new Date(); 																																																		777
    }
		const steps = [ 5, 10, 15, 20, 30, 60 ];
    if (! steps.includes(settings.stepMinutes)) {
      settings.stepMinutes = 5;
    }
    decrement = settings.stepMinutes / 5;
    step = 12;
		while (step) {
      visibleSteps.push(step);
      step -= decrement;
		}
    // round minutes to step
		if (settings.step && settings.datetime.getMinutes() % settings.stepMinutes)
			{
      settings.datetime.setMinutes(Math.round((settings.datetime.getMinutes() / settings.stepMinutes) + 0.5) * settings.stepMinutes);
			}

    // Hide Header on small screens
    if ( $(window).height() < 600 ) {
      $("#timepicker-header").hide();
    }
    else {
      $("#timepicker-header").show();
    }

    // Start Clock with Hours
    _setClockFace("hours", settings.datetime, settings.callback);

    return true;
  }

  /**
   * DISPLAY THE CLOCK FACE
   * @param {string} display hours or mins
   * @param {Date} selected The selected Time
   * @param {function} callback Selected Time callback function
   */
  function _setClockFace(display, selected, callback) {

    // Set factor
    let factor = 1;
    if ( display === "mins" ) {
      factor = 5;
    }

    // Get Time Components
    let comp = _parseTime(selected);

    // Set background color of header
    $(".timepicker-bg").css({
      "background-color": PRIMARY_COLOR,
    });

    // Set Header Time
    $("#timepicker-hour").html(comp.hour + ":");
    $("#timepicker-mins").html(comp.mins);
    $("#timepicker-ampm").html(comp.ampm);
    if ( display === "hours" ) {
      $("#timepicker-hour").fadeTo(0, 0.9);
      $("#timepicker-mins").fadeTo(0, 0.6);
    }
    else if ( display === "mins" ) {
      $("#timepicker-hour").fadeTo(0, 0.6);
      $("#timepicker-mins").fadeTo(0, 0.9);
    }
    $("#timepicker-ampm").fadeTo(0, 0.9);

    // SET CLOCK FACE NUMBERS //
    $(".timepicker-hour").each(function() {
      let val = $(this).attr("data-value");
      val = val * factor;
      val = "" + val;
      if ( val === "60" ) {
        val = "0";
      }
      if ( factor > 1 ) {
        if ( val.length === 1 ) {
          val = "0" + val;
        }
      }

      // Find selected hour
      if ( display === "hours" ) {
        if ( parseInt(val) === parseInt(comp.hour) ) {
          $(this).addClass("selected");
        }
        else {
          $(this).removeClass("selected");
        }
      }
      else if ( display === "mins" ) {
        if ( parseInt(val) === parseInt(comp.mins) ) {
          $(this).addClass("selected");
        }
        else {
          $(this).removeClass("selected");
        }
      }

      // Set Number Value
      $(this).html(val);

      // Set Number Click Listener
      $(this).off('click').on('click', function() {
        _numberSelected(display, val, selected, callback);
      });

    });

    // Move each value
    $(".timepicker-hour").each(function() {
      let val = $(this).attr("data-value");
      let deg = valToDeg[val];
      if ('mins' == display && ! visibleSteps.includes(parseInt(val))) { // disabled, hide it
        $(this).hide();
			} else {
        $(this).show();
      }
			let x = radius * Math.cos(_getRad(deg));
      let y = radius * Math.sin(_getRad(deg));

      let xd = 1;
      let yd = -1;
      if ( val >= 6 ) {
        xd = -1;
      }
      if ( val > 3 && val < 9 ) {
        yd = 1;
      }

      // Original coordinates to offset from
      let left = 111;
      let top = 112;

      $(this).css({
        "position": "absolute",
        "left": (left + xd * x) + "px",
        "top": (top + yd * y) + "px"
      });

      $(this).animate({opacity: 0.9}, 0);
    });

    // Set Clock Hand Position
    let selectedVal = $(".timepicker-hour.selected").attr("data-value");
    $("#timepicker-hour-hand").addClass("rotate" + (selectedVal * 30));
    $("#timepicker-hour-hand").fadeTo(250, 0.4);

    // Set style for numbers
    $(".timepicker-hour").hover(function(e) {
      $(this).css({
        "background-color": e.type === "mouseenter" ? PRIMARY_COLOR : "transparent",
        "color": e.type === "mouseenter" ? "white" : "black",
        "opacity": e.type === "mouseenter" ? 0.5 : 1.0,
      });
      $(".timepicker-hour.selected").css({
        "background-color": PRIMARY_COLOR,
        "color": "white"
      });
    });
    $(".timepicker-hour.selected").css({
      "background-color": PRIMARY_COLOR,
      "color": "white"
    });

    // Set the AMPM Buttons
    _setAMPMButtons(comp.ampm);

    // Set Button Text Color
    $("#timepicker-now-button").css("color", PRIMARY_COLOR);
    $("#timepicker-clear-button").css("color", PRIMARY_COLOR);
    $("#timepicker-cancel-button").css("color", PRIMARY_COLOR);
    $("#timepicker-set-button").css("color", PRIMARY_COLOR);

    // Set click listeners
    $("#timepicker-hour").off('click').on('click', function() {
      _hideClockFace();
      _setClockFace("hours", selected, callback);
    });
    $("#timepicker-mins").off('click').on('click', function() {
      _hideClockFace();
      _setClockFace("mins", selected, callback);
    });
    $("#timepicker-am-button").off('click').on('click', function() {
      if ( selected.getHours() > 11 ) {
        selected.setHours(selected.getHours() - 12);
      }
      _hideClockFace();
      _setClockFace(display, selected, callback);
    });
    $("#timepicker-pm-button").off('click').on('click', function() {
      if ( selected.getHours() < 12 ) {
        selected.setHours(selected.getHours() + 12);
      }
      _hideClockFace();
      _setClockFace(display, selected, callback);
    });
    $("#timepicker-now-button").off('click').on('click', function() {
      _hideClockFace();
      settings.datetime = new Date();
      _setup();
    });
    $("#timepicker-clear-button").off('click').on('click', function() {
      hide();
      return callback(null);
    });
    $("#timepicker-cancel-button").off('click').on('click', function() {
      _hideClockFace();
      hide();
    });
    $("#timepicker-set-button").off('click').on('click', function() {
      hide();
      return callback(_minMaxTime(selected));
    });
  }

  /**
   * Callback function for a selected clock face number
   * @param {string} display hours or mins
   * @param {number|string} val Value of number selected
   * @param {Date} selected The selected DateTime
   * @param {function} callback Selected Time callback function
   * @private
   */
  function _numberSelected(display, val, selected, callback) {
    if ( display === "hours" ) {
      if ( selected.getHours() > 12 ) {
        selected.setHours(parseInt(val) + 12);
      }
      else {
        selected.setHours(parseInt(val));
      }
    }
    else if ( display === "mins" ) {
      selected.setMinutes(parseInt(val));
    }

    _hideClockFace();
    _setClockFace("mins", selected, callback);
  }

  /**
   * Hide the Clock Face and Reset the Styles
   * @private
   */
  function _hideClockFace() {
    // Reset clock hand
    $("#timepicker-hour-hand").fadeTo(0, 0.0);
    for ( let i = 0; i <= 360; i = i + 30 ) {
      $("#timepicker-hour-hand").removeClass("rotate" + i);
    }

    // Reset Header
    $("#timepicker-hour").fadeTo(0, 0.4);
    $("#timepicker-mins").fadeTo(0, 0.4);
    $("#timepicker-ampm").fadeTo(0, 0.4);

    // Move each value
    $(".timepicker-hour").each(function() {
      $(this).removeClass("selected");
      $(this).css({
        "background-color": "transparent",
        "color": "black"
      });
      $(this).animate({opacity: 0.4}, 0);
    });
  }

  /**
   * Set the selected State and Style of the AM/PM Buttons
   * @param {string} ampm AM or PM
   * @private
   */
  function _setAMPMButtons(ampm) {

    // Set the header value
    $("#timepicker-ampm").html(ampm);

    // AM
    if ( ampm === "AM" ) {
      $("#timepicker-am-button").css({
        "background-color": PRIMARY_COLOR,
        "color": "white"
      });
      $("#timepicker-pm-button").css({
        "background-color": "#e3e6e9",
        "color": "black"
      });

      $("#timepicker-pm-button").hover(function(e) {
        $(this).css({
          "background-color": e.type === "mouseenter" ? PRIMARY_COLOR : "#e3e6e9",
          "color": e.type === "mouseenter" ? "white" : "black",
          "opacity": e.type === "mouseenter" ? 0.5 : 1.0
        });
      });
      $("#timepicker-am-button").hover(function() {
        $(this).css({
          "background-color": PRIMARY_COLOR,
          "color": "white",
          "opacity": 1.0
        });
      });
    }

    // PM
    else if ( ampm === "PM" ) {
      $("#timepicker-pm-button").css({
        "background-color": PRIMARY_COLOR,
        "color": "white"
      });
      $("#timepicker-am-button").css({
        "background-color": "#e3e6e9",
        "color": "black"
      });

      $("#timepicker-am-button").hover(function(e) {
        $(this).css({
          "background-color": e.type === "mouseenter" ? PRIMARY_COLOR : "#e3e6e9",
          "color": e.type === "mouseenter" ? "white" : "black",
          "opacity": e.type === "mouseenter" ? 0.5 : 1.0
        });
      });
      $("#timepicker-pm-button").hover(function() {
        $(this).css({
          "background-color": PRIMARY_COLOR,
          "color": "white",
          "opacity": 1.0
        });
      });
    }

  }

  /**
   * Parse the Date/Time into hour, mins and ampm components
   * @param {Date} datetime The JS Date to parse into time components
   * @returns {{hour: number|string, mins: number|string, ampm: string}}
   * @private
   */
  function _parseTime(datetime) {
    let hour = datetime.getHours();
    let mins = datetime.getMinutes();
    let ampm = "";

    if (60 === mins) {
      mins = 0;
      let d = new Date(datetime);
      d.setTime(d.getTime() + (60 * 60 * 1000));
      hour = d.getHours();
    }
    if (mins < 10) {
      mins = "0" + mins;
    }

    if (hour > 11) {
      ampm = "PM";
    }
    else {
      ampm = "AM";
    }

    if (hour > 12) {
      hour -= 12;
    }
    if (0 === hour) {
      hour = 12;
      ampm = "AM";
    }
		datetime.setSeconds(0);
		datetime.setMinutes(mins);

    // Return the Components
    return {
      hour: hour,
      mins: mins,
      ampm: ampm
    }
  }

  /**
   * Convert Degrees to Radians
   * @param deg Degrees
   * @returns {number} Radians
   * @private
   */
  function _getRad(deg) {
    return deg * Math.PI / 180;
  }

  function _getAttribute(name, setting) {
		if (setting === null) {
      attribute = settings.parent.attr(name);
      if (attribute !== undefined) {
        return attribute;
  		}
    }
    return setting;
  }

  /**
   * Apply min and max values to returned time
   * @param {Date} datetime
   * @returns {Date} corrected datetime
   * @private
   */
  function _minMaxTime(datetime) {
    let seconds = datetime.getHours() * 3600 + datetime.getMinutes() * 60 + datetime.getSeconds();
		if (settings.min !== null && seconds < settings.min) {
      seconds = settings.min;
		} else if (settings.max !== null && seconds > settings.max) {
      seconds = settings.max;
    }
    datetime.setHours(Math.floor(seconds / 3600));
    datetime.setMinutes(Math.floor((seconds - datetime.getHours() * 3600) / 60));
		datetime.setSeconds(seconds % 60);

    return datetime;
  }

	/**
   * @param {string} time
   * @return {integer} seconds
	 */
  function _getSeconds(time) {
		if (time === null) {
      return time;
			}
		let seconds = 0;
    let mod = 3600;
    return time.split(':').reduce(function (seconds, v) {
      let value = v + seconds * mod;
      mod /= 60;
      return value;
    });
  }

  // Return show and hide functions
  return {
    show: show,
    hide: hide
  }

};