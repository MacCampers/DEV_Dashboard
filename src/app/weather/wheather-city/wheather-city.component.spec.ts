import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { WheatherCityComponent } from './wheather-city.component';

describe('WheatherCityComponent', () => {
  let component: WheatherCityComponent;
  let fixture: ComponentFixture<WheatherCityComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ WheatherCityComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(WheatherCityComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
