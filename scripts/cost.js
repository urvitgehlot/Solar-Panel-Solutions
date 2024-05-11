
var sunLightHours = {
  hours: 0,
  minutes: 0,
}

function updateNumberofPanelSlider() {
  let location = document.querySelector('.location-group input').value;
  let openRoof = {
    'width': parseInt(document.querySelector('.open-roof-width input').value),
    'height': parseInt(document.querySelector('.open-roof-height input').value),
  }
  let monthlyConsuption = parseInt(document.querySelector('.monthly-consuption-group input').value);
  let unitCost = parseInt(document.querySelector('.unit-cost-group input').value);
  let panelType = document.querySelector('.panel-type-input').value;

  if(
    !location ||
    !openRoof['height'] ||
    !openRoof['width'] ||
    !monthlyConsuption ||
    // !unitCost ||
    !panelType
  ) return;

  const postData = {
    'location': location,
  }

  fetch("./php/sun_time.php", {
    method: 'POST',
    headers: {
      'content-Type': 'application/json',
    },
    body: JSON.stringify(postData)
  })
  .then(response => response.json())
  .then(data => {
    var verifiedIcon = document.querySelector('.location-group .verified-icon i');
    if (!data.success) {
      if (verifiedIcon.classList.contains('fa-circle-check')) {
        verifiedIcon.classList.replace('fa-circle-check', 'fa-circle-xmark');
      }
      else {
        verifiedIcon.classList.add('fa-circle-xmark');
      }
      alert(data.message);
    }
    else {
      if (verifiedIcon.classList.contains('fa-circle-xmark')) {
        verifiedIcon.classList.replace('fa-circle-xmark', 'fa-circle-check');
      }
      else {
        verifiedIcon.classList.add('fa-circle-check');
      }
      sunLightHours.hours = data.hours;
      sunLightHours.minutes = data.minutes;

      let areaOfRoof = openRoof['height'] * openRoof['width'];
      let areaOfPanel = 0;
      let panelWatt = 0;
      if(panelType === "60 cell"){
        areaOfPanel = 17.875;
        panelWatt = 250;
      }else if(panelType === "72 cell"){
        areaOfPanel = 20.865;
        panelWatt = 350;
      }

      let totalPanelsCanFit = parseInt(areaOfRoof / areaOfPanel);      
      let totalUnit = (panelWatt * sunLightHours.hours * 30)/1000;
      let panelNeeded =  Math.ceil((monthlyConsuption + (2000/monthlyConsuption)) / totalUnit);
      let recommendedNoOfPanel = panelNeeded;
      
      if(panelNeeded >= totalPanelsCanFit) {
        recommendedNoOfPanel = totalPanelsCanFit;  
      }

      document.getElementById('recommended-panels').textContent = recommendedNoOfPanel;

      var rangeSliderInput = document.querySelector('.no-of-panel-slider');
      rangeSliderInput.setAttribute('value', recommendedNoOfPanel);
      rangeSliderInput.setAttribute('min', "1");
      rangeSliderInput.setAttribute('max', totalPanelsCanFit.toString());

      let calculatedPer = (recommendedNoOfPanel - 1) * 100 / (totalPanelsCanFit - 1);
      
      document.getElementById('slider-value').style.left = calculatedPer+'%';
      document.getElementById('slider-value').style.transform = "translateX(-"+ (calculatedPer) +"%)";
      document.getElementById('slider-value').textContent = recommendedNoOfPanel;

      var val = calculatedPer + '% 100%';
      
      var str = '.no-of-panel-slider' + track_sel[0] + '{background-size:' + val + '}';

      styles[0] = str;
      style_el.textContent = styles.join('');


    }
  })
  .catch(error => {
    console.error('Error: ', error);
  });
}


document.getElementById('location').addEventListener('change', function (event) {
  if (this.value) {
    updateNumberofPanelSlider();
    // console.log(this.value);

    const postData = {
      'location': this.value,
    }

    fetch("./php/sun_time.php", {
      method: 'POST',
      headers: {
        'content-Type': 'application/json',
      },
      body: JSON.stringify(postData)
    })
    .then(response => response.json())
    .then(data => {
      var verifiedIcon = document.querySelector('.location-group .verified-icon i');
      if (!data.success) {
        if (verifiedIcon.classList.contains('fa-circle-check')) {
          verifiedIcon.classList.replace('fa-circle-check', 'fa-circle-xmark');
        }
        else {
          verifiedIcon.classList.add('fa-circle-xmark');
        }
        alert(data.message);
      }
      else {
        if (verifiedIcon.classList.contains('fa-circle-xmark')) {
          verifiedIcon.classList.replace('fa-circle-xmark', 'fa-circle-check');
        }
        else {
          verifiedIcon.classList.add('fa-circle-check');
        }
        // console.log(data);
      }
    })
    .catch(error => {
      console.error('Error: ', error);
    });
  } else {
    var verifiedIcon = document.querySelector('.location-group .verified-icon i');
    if (verifiedIcon.classList.contains('fa-circle-check')) {
      verifiedIcon.classList.replace('fa-circle-check', 'fa-circle-xmark');
    }
    else {
      verifiedIcon.classList.add('fa-circle-xmark');
    }
  }

});


document.querySelector('.open-roof-width input').addEventListener('change', function (event) {
  if (this.value) {
    // document.
    updateNumberofPanelSlider();
  }
});
document.querySelector('.open-roof-height input').addEventListener('change', function (event) {
  if (this.value) {
    // document.
    updateNumberofPanelSlider();
  }
});

document.querySelector('.monthly-consuption-group input').addEventListener('change', function (event) {
  if (this.value) {
    // document.
    updateNumberofPanelSlider();
  }
});




function submitForm(){
  let location = document.querySelector('.location-group input').value;
  let openRoof = {
    'width': parseInt(document.querySelector('.open-roof-width input').value),
    'height': parseInt(document.querySelector('.open-roof-height input').value),
  }
  let monthlyConsuption = parseInt(document.querySelector('.monthly-consuption-group input').value);
  let unitCost = parseInt(document.querySelector('.unit-cost-group input').value);
  let panelType = document.querySelector('.panel-type-input').value;

  if(
    !location ||
    !openRoof['height'] ||
    !openRoof['width'] ||
    !monthlyConsuption ||
    !unitCost ||
    !panelType
  ) return false;

  return true;

}
