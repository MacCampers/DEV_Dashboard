import { Component, OnInit } from '@angular/core';
import { AuthService } from '../authentification/services/auth.service';
import { WeatherService } from '../weather/weather-service.service';
import { MapService } from '../map/map-service.service';
import { CalendarService } from '../calendar/service.service';
import { NewsApiService } from '../news/news-api.service';
import { YoutubeService } from '../youtube/youtube.service';

@Component({
  selector: 'app-widget',
  templateUrl: './widget.component.html',
  styleUrls: ['./widget.component.css']
})
export class WidgetComponent implements OnInit {

  constructor(public authService: AuthService, private weatherService: WeatherService, private mapService: MapService,
    private calendarService: CalendarService, private newsApiService: NewsApiService, private youtubeService: YoutubeService) { }

  ngOnInit() {
  }

  activateWeather() {
    this.weatherService.updateIsActive1();
  }

  desactivateWeather() {
    this.weatherService.updateIsActive0();
  }


  activateMap() {
    this.mapService.updateIsActive1();
  }

  desactivateMap() {
    this.mapService.updateIsActive0();
  }

  activateCalendar() {
    this.calendarService.updateIsActive1();
  }

  desactivateCalendar() {
    this.calendarService.updateIsActive0();
  }

  activateNews() {
    this.newsApiService.updateIsActive1();
  }

  desactivateNews() {
    this.newsApiService.updateIsActive0();
  }

  activateYoutube() {
    this.youtubeService.updateIsActive1();
  }

  desactivateYoutube() {
    this.youtubeService.updateIsActive0();
  }
}
