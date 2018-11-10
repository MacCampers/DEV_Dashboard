import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-about-json',
  templateUrl: './about-json.component.html',
  styleUrls: ['./about-json.component.css'],
})
export class AboutJsonComponent implements OnInit {
  sample: any;

  constructor() { }

  ngOnInit() {
    this.sample = [{
      "client": {
        "host": "0.0.0.0"
      },
      "server": {
        "current_time": 1540285200,
        "services": [{
          "name": "weather",
          "widgets": [{
            "name": "weather",
            " description ": "Affichage de la temperature pour une ville",
            " params ": [{
              "name": "city",
              "type ": "string"
            }, {
              "name": "position",
              "type": "integer"
            }, {
              "name": "isActive",
              "type": "integer"
            }]
          }]
        }, {
          " name ": "Google Map",
          " widgets ": [{
            " name ": "map",
            " description ": "Affiche l'api google map",
            " params ": [{
              " name ": "position",
              " type ": "integer"
            }, {
              " name ": "isActive",
              " type ": "integer"
            }]
          }]
        }, {
          " name ": "Calendar",
          " widgets ": [{
            " name ": "calendar",
            " description ": "Calendrier interactif avec création d'event",
            " params ": [{
              " name ": "position",
              " type ": "integer"
            }, {
              " name ": "isActive",
              " type ": "integer"
            }]
          }]

        }]
      }
    }]
  }
}