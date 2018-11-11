import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule } from '@angular/http';
import { HttpClientModule } from '@angular/common/http';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { CommonModule } from '@angular/common';
import { FlatpickrModule } from 'angularx-flatpickr';
import { CalendarModule, DateAdapter } from 'angular-calendar';
import { adapterFactory } from 'angular-calendar/date-adapters/date-fns';
import { NgbModalModule } from '@ng-bootstrap/ng-bootstrap';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatButtonModule, MatCardModule, MatMenuModule, MatToolbarModule, MatIconModule, MatSidenavModule, MatListModule } from '@angular/material';
import { NewsApiService } from './news/news-api.service'

//firebase
import { AngularFireModule, FirebaseAppConfig } from 'angularfire2';
import { AngularFireDatabaseModule } from 'angularfire2/database';
import { AngularFireAuthModule } from 'angularfire2/auth';

import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RouterModule, Routes } from '@angular/router';

//custom component
import { AppComponent } from './app.component';
import { AgmCoreModule, GoogleMapsAPIWrapper } from '@agm/core';
import { AboutJsonComponent } from './about-json/about-json.component';
//user
import { RegisterUserComponent } from './authentification/register-user/register-user.component';
import { EmailVerificationComponent } from './authentification/email-verification/email-verification.component';
import { UserSettingComponent } from './authentification/user-setting/user-setting.component';
//master
import { HeaderComponent } from './master/header/header.component';
import { SidebarComponent } from './master/sidebar/sidebar.component';
import { BackendHomeComponent } from './backend/backend-home/backend-home.component';
import { DashboardComponent } from './dashboard/dashboard.component';
//widget
import { WidgetComponent } from './widget/widget.component';
import { MapComponent } from './map/map.component';
import { CalendarComponent } from './calendar/calendar.component';

//services
import { AuthService } from './authentification/services/auth.service';
import { WeatherCityComponent } from './weather/weather-city/weather-city.component';
import { WeatherSettingComponent } from './weather/weather-setting/weather-setting.component';
import { NewsComponent } from './news/news/news.component';
import { YoutubeComponent } from './youtube/youtube.component';
import { MovieComponent } from './movie/movie/movie.component';


const CONFIG: FirebaseAppConfig = {
  apiKey: "AIzaSyCMfUWvrSMgpSQm097Rtk_CNlZoqp8O_FQ",
  authDomain: "epitechdashboard.firebaseapp.com",
  databaseURL: "https://epitechdashboard.firebaseio.com",
  projectId: "epitechdashboard",
  storageBucket: "epitechdashboard.appspot.com",
  messagingSenderId: "983619226651"
};

const ROUTES: Routes = [
  { path: '', component: RegisterUserComponent, pathMatch: 'full' },
  { path: 'dashboard', component: DashboardComponent},
  { path: 'emailSection', component: EmailVerificationComponent },
  { path: 'userSettings', component: UserSettingComponent },
  { path: 'widget', component: WidgetComponent },
  { path: 'about.json', component: AboutJsonComponent },
  { path: 'admin', component: BackendHomeComponent },
];

@NgModule({
  declarations: [
    AppComponent,
    BackendHomeComponent,
    RegisterUserComponent,
    DashboardComponent,
    EmailVerificationComponent,
    WidgetComponent,
    UserSettingComponent,
    HeaderComponent,
    SidebarComponent,
    WeatherCityComponent,
    WeatherSettingComponent,
    MapComponent,
    CalendarComponent,
    AboutJsonComponent,
    NewsComponent,
    YoutubeComponent,
    MovieComponent,
  ],
  imports: [
    BrowserModule,
    AngularFireModule.initializeApp(CONFIG),
    AngularFireDatabaseModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule.forRoot(ROUTES),
    AngularFireAuthModule,
    HttpModule,
    HttpClientModule,
    AgmCoreModule.forRoot({
      apiKey: 'AIzaSyBXFtghGl5A9XtMe2jhfmIA1ALC2SptoWg'
    }),
    NgbModule.forRoot(),
    CommonModule,
    FormsModule,
    NgbModalModule,
    FlatpickrModule.forRoot(),
    CalendarModule.forRoot({
      provide: DateAdapter,
      useFactory: adapterFactory
    }),
    BrowserModule,
    BrowserAnimationsModule,
    MatButtonModule,
    MatMenuModule,
    MatCardModule,
    MatToolbarModule,
    MatIconModule,
    MatSidenavModule,
    MatListModule,
  ],
  providers: [
    AuthService,
    GoogleMapsAPIWrapper,
    NewsApiService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
