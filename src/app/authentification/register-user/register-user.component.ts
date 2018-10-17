import { Component, OnInit } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-register-user',
  templateUrl: './register-user.component.html',
  styleUrls: ['./register-user.component.css']
})
export class RegisterUserComponent implements OnInit {

  newUser = { email: '', password: '' };
  existingUser = { email: '', password: '' };

  constructor(public authService: AuthService, private router: Router) { }

  ngOnInit() {
  }

  registerUser() {
    this.authService.register(this.newUser.email, this.newUser.password)
    .then(createdUser => {
        this.router.navigate(['emailSection']);
    })
    .catch(error => console.log(error.message));
  }

  loginUser() {
    this.authService.login(this.existingUser.email, this.existingUser.password)
    .then(value => {
      this.router.navigate(['dashboard']);
    })
    .catch(err => {
      console.error('erreur :', err.message)
    })
  }

}
