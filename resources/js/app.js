import "./bootstrap";

import { createApp } from 'vue';

const apps = {
  welcome: import('./Welcome.vue'),
  converse: import('./Feature/Converse.vue'),
};

Object.keys(apps).forEach((appKey) => {
  const mountPoint = document.querySelector(`#${appKey}-app`);

  if (mountPoint) {
    apps[appKey].then((module) => {
      const app = createApp(module.default);
      app.mount(`#${appKey}-app`);
    });
  }
});
