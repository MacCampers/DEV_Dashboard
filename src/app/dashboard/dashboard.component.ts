import { Component, OnInit } from '@angular/core';
import { AuthService } from '../authentification/services/auth.service';
import { Router } from '@angular/router';
import { WeatherService } from '../weather/weather-service.service';
import { MapService } from '../map/map-service.service';
import { CalendarService } from '../calendar/service.service';
import { NewsApiService } from '../news/news-api.service';
import { Location } from '@angular/common';
import { YoutubeService } from '../youtube/youtube.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

  isActiveWeather: number;
  isActiveMap: number;
  isActiveCalendar: number;
  isActiveNews: number;
  isActiveyt: number;

  constructor(public authService: AuthService, private router: Router, private weatherService: WeatherService,
    private mapService: MapService, private calendarService: CalendarService, private newsApiService: NewsApiService, private youtubeservice: YoutubeService,private location: Location) { }

  onCityUpdated(city) {
    this.weatherService.updateCity({
      city: city.value.city
    });
  }

  desactivateWeather() {
    this.weatherService.updateIsActive0();
    location.reload();
  }

  desactivateMap() {
    this.mapService.updateIsActive0();
    location.reload();
  }

  desactivateCalendar() {
    this.calendarService.updateIsActive0();
    location.reload();
  }

  desactivateNews() {
    this.newsApiService.updateIsActive0();
    location.reload();
  }

  desactivateYoutube() {
    this.youtubeservice.updateIsActive0();
    location.reload();
  }


  ngOnInit() {
    this.weatherService.getWeatherDatabase().then(z => {
      this.isActiveWeather = z.isActive;
    })
    this.mapService.getMapDatabase().then(x => {
      this.isActiveMap = x.isActive;
    })
    this.calendarService.getCalendarDatabase().then(x => {
      this.isActiveCalendar = x.isActive;
    })
    this.newsApiService.getNewsDatabase().then(x => {
      this.isActiveNews = x.isActive;
    })
    this.youtubeservice.getYoutubeDatabase().then(x => {
      this.isActiveyt = x.isActive;
    })
  }
}
