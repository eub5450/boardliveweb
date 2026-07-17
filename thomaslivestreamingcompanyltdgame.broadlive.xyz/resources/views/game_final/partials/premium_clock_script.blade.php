<script>
  (function(){
    function setTimer(config){
      if(!config) return;
      var root = config.root || null;
      var value = config.value || null;
      var sub = config.sub || null;
      var text = config.text == null ? '--' : String(config.text);
      var progress = Number(config.progress);
      var clamped = Number.isFinite(progress) ? Math.max(0, Math.min(1, progress)) : 0;

      if(root){
        root.style.setProperty('--p', clamped.toFixed(4));
        root.style.setProperty('--timer-angle', (-90 + ((1 - clamped) * 360)).toFixed(2) + 'deg');
        if(config.color){
          root.style.setProperty('--timer-color', config.color);
        } else {
          root.style.removeProperty('--timer-color');
        }
        root.classList.toggle('gf-alert', !!config.alert);
        root.classList.toggle('gf-ended', !!config.ended);
        root.classList.toggle('disabled', !!config.disabled);
      }

      if(value){
        value.textContent = text;
        value.setAttribute('data-value', text);
        value.classList.toggle('small', !!config.small);
      }

      if(sub && Object.prototype.hasOwnProperty.call(config, 'subText')){
        sub.textContent = config.subText;
      }
    }

    window.BDPremiumCountdown = window.BDPremiumCountdown || { set: setTimer };
  })();
</script>