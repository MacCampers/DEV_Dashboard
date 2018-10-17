import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { WheatherWidgetComponent } from './wheather-widget.component';

describe('WheatherWidgetComponent', () => {
  let component: WheatherWidgetComponent;
  let fixture: ComponentFixture<WheatherWidgetComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ WheatherWidgetComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(WheatherWidgetComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
