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
import { WheatherCityComponent } from './weather/wheather-city/wheather-city.component';
import { WheatherAddCityComponent } from './weather/wheather-add-city/wheather-add-city.component';

//services
import { AuthService } from './authentification/services/auth.service';
import { WheatherService } from './weather/wheather-service.service';


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
 // { path: 'city/:city', component: WheatherCityComponent },
  { path: 'add-city', component: WheatherAddCityComponent },
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
    WheatherCityComponent,
    WheatherAddCityComponent,
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
    HttpClientModule
  ],
  providers: [
    AuthService,
    WheatherService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
