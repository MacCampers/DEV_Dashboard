import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-map',
  templateUrl: './map.component.html',
  styleUrls: ['./map.component.css']
})
export class MapComponent implements OnInit {

  constructor() { }

  title: string = 'My first AGM project';
  lat: number = 43.700000;
  lng: number = 7.250000;

  ngOnInit() {
  }

}
