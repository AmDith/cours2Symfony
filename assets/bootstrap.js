// assets/bootstrap.js
import { startStimulusApp } from "@symfony/stimulus-bridge";

// Initialize Stimulus application
const app = startStimulusApp(
  require.context(
    "./controllers", // Assure-toi que ce chemin correspond à l'emplacement de tes contrôleurs
    true,
    /\.(j|t)sx?$/
  )
);
