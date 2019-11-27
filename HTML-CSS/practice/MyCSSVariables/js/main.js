'use strict';

{
  const btn = document.getElementById('btn');
  btn.addEventListener('click', () => {
    document.documentElement.style.setProperty('--my-hue', Math.floor(Math.random() * 360));
  });
}