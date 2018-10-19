import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpModule } from '@angular/http';
import { HttpClientModule } from '@angular/common/http';

//firebase
import { AngularFireModule, FirebaseAppConfig } from 'angularfire2';
import { AngularFireDatabaseModule } from 'angularfire2/database';
import { AngularFireAuthModule } from 'angularfire2/auth';

import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RouterModule, Routes } from '@angular/router';

//custom component
import { AppComponent } from './app.component';
import { AgmCoreModule } from '@agm/core';
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

//services
import { AuthService } from './authentification/services/auth.service';
import { WeatherCityComponent } from './weather/weather-city/weather-city.component';
import { WeatherSettingComponent } from './weather/weather-setting/weather-setting.component';
import { MapComponent } from './map/map.component';


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
    })
  ],
  providers: [
    AuthService,
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
