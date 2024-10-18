// assets/controllers/live_controller.js

import { Controller } from "@hotwired/stimulus";
import { useDebounce } from "stimulus-use";

export default class extends Controller {
  static debounces = ["update"];
  static values = { name: String, telephone: String };

  connect() {
    useDebounce(this, { wait: 300 }); // Déclencher la mise à jour après un délai
  }

  update() {
    const element = this.element as HTMLElement;
    this.element.dataset.liveTelephoneValue = this.telephoneValue;
  }
}
