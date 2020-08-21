( function( $, _, Backbone, builderSettings, sectionData ) {

	var Model = Backbone.Model.extend( {
		defaults: function() {
			return _.extend( {}, sectionData.defaults.gallery, {
				id: _.uniqueId( 'gallery_' ),
			} );
		},

		initialize: function( attrs ) {
			this.items = attrs['gallery-items'];
			this.set( 'gallery-items', new Backbone.Collection(), { silent: true } );
		},
	} );

	var ItemModel = Backbone.Model.extend( {
		defaults: function() {
			return _.extend( {}, sectionData.defaults['gallery-item'], {
				id: _.uniqueId( 'gallery-item_' ),
			} );
		},
	} );

	var View = obspgb.classes.SectionView.extend( {
		template: wp.template( 'ttfobspgb-section-gallery' ),

		events: _.extend( {}, obspgb.classes.SectionView.prototype.events, {
			'click .ttfobspgb-section-configure': 'onConfigureSectionClick',
			'click .ttfobspgb-gallery-add-item-link': 'onAddItemClick',
		} ),

		initialize: function() {
			obspgb.classes.SectionView.prototype.initialize.apply( this, arguments );
			this.itemViews = new Backbone.Collection();
		},

		afterRender: function() {
			obspgb.classes.SectionView.prototype.afterRender.apply( this, arguments );

			this.listenTo( this.model, 'change:columns', this.onColumnCountChanged );
			this.listenTo( this.model.get( 'gallery-items' ), 'add', this.onItemModelAdded );
			this.listenTo( this.model.get( 'gallery-items' ), 'remove', this.onItemModelRemoved );
			this.listenTo( this.model.get( 'gallery-items' ), 'reset', this.onItemModelsSorted );
			this.listenTo( this.model.get( 'gallery-items' ), 'add remove change reset', this.onItemCollectionChanged );
			this.listenTo( this.itemViews, 'add', this.onItemViewAdded );
			this.listenTo( this.itemViews, 'remove', this.onItemViewRemoved );
			this.listenTo( this.itemViews, 'reset', this.onItemViewsSorted );

			var items = this.model.items || _.times( 3, _.constant( sectionData.defaults['gallery-item'] ) );
			var itemCollection = this.model.get( 'gallery-items' );

			_.each( items, function( itemAttrs ) {
				var itemModel = obspgb.factory.model( itemAttrs );
				itemModel.parentModel = this.model;
				itemCollection.add( itemModel );
			}, this );

			this.initSortables();
			this.on( 'sort-start', this.onItemSortStart, this );
			this.on( 'sort-stop', this.onItemSortStop, this );
		},

		onColumnCountChanged: function( itemModel ) {
			var newColumnCount = this.model.get( 'columns' );
			var $stage = $( '.ttfobspgb-gallery-items-stage', this.$el );

			$stage.removeClass( function( i, className ) {
				return className.match( /ttfobspgb-gallery-columns-[0-9]/g || [] ).join( ' ' );
			});

			$stage.addClass( 'ttfobspgb-gallery-columns-' + newColumnCount );
		},

		onItemModelAdded: function( itemModel, itemCollection, options ) {
			var itemView = obspgb.factory.view( { model: itemModel } );

			if ( itemView ) {
				var itemIndex = itemCollection.indexOf( itemModel );
				var itemViewModel = new Backbone.Model( { id: itemModel.id, view: itemView } );
				this.itemViews.add( itemViewModel, _.extend( options, { at: itemIndex } ) );
			}
		},

		onItemModelRemoved: function( itemModel ) {
			var itemViewModel = this.itemViews.get( itemModel.id );
			this.itemViews.remove( itemViewModel );
		},

		onItemModelsSorted: function( itemCollection ) {
			this.itemViews.reset( _.map( itemCollection.pluck( 'id' ), function( id ) {
				return this.itemViews.get( id );
			}, this ) );
		},

		onItemCollectionChanged: function() {
			this.model.trigger( 'change' );
		},

		onItemViewAdded: function( itemViewModel, itemViewCollection, options ) {
			var itemViewIndex = this.itemViews.indexOf( itemViewModel );
			var $itemViewEl = itemViewModel.get( 'view' ).render().$el;

			if ( 0 === itemViewIndex ) {
				$( '.ttfobspgb-gallery-items-stage', this.$el ).prepend( $itemViewEl );
			} else {
				var previousItemViewModel = this.itemViews.at( itemViewIndex - 1 );
				previousItemViewModel.get( 'view' ).$el.after( $itemViewEl );
			}

			itemViewModel.get( 'view' ).trigger( 'rendered' );

			if ( options.scroll ) {
				window.obspgb.builder.scrollToView( itemViewModel.get( 'view' ) );
			}
		},

		onItemViewRemoved: function( itemViewModel ) {
			itemViewModel.get( 'view' ).$el.animate( {
				opacity: 'toggle',
				height: 'toggle'
			}, builderSettings.closeSpeed, function() {
				itemViewModel.get( 'view' ).remove();
			} );
		},

		onItemViewsSorted: function( itemViewCollection ) {
			var $stage = $( '.ttfobspgb-gallery-items-stage', this.$el );

			itemViewCollection.forEach( function( itemViewModel ) {
				var $itemViewEl = itemViewModel.get( 'view' ).$el;
				$itemViewEl.detach();
				$stage.append( $itemViewEl );
			}, this );
		},

		initSortables: function() {
			var $sortable = $( '.ttfobspgb-gallery-items-stage', this.$el );

			$sortable.sortable( {
				handle: '.ttfobspgb-sortable-handle',
				placeholder: 'sortable-placeholder',
				forcePlaceholderSizeType: true,
				distance: 2,
				tolerance: 'pointer',

				start: function ( e, ui ) {
					this.trigger( 'sort-start', e, ui );
				}.bind( this ),

				stop: function ( e, ui ) {
					this.trigger( 'sort-stop', e, ui );
				}.bind( this ),
			} );
		},

		onItemSortStart: function( e, ui ) {
			ui.placeholder.height( ui.item.height() - 2 );
		},

		onItemSortStop: function( e, ui ) {
			var $sortable = $( '.ttfobspgb-gallery-items-stage', this.$el );
			var ids = $sortable.sortable( 'toArray', { attribute: 'data-id' } );

			this.model.get( 'gallery-items' ).reset( _.map( ids, function( id ) {
				return this.model.get( 'gallery-items' ).get( id );
			}, this ) );
		},

		onAddItemClick: function( e ) {
			e.preventDefault();

			var itemModel = obspgb.factory.model( sectionData.defaults['gallery-item'] );
			itemModel.parentModel = this.model;
			this.model.get( 'gallery-items' ).add( itemModel, { scroll: true } );
		},

		onConfigureSectionClick: function( e ) {
			e.preventDefault();

			var sectionType = this.model.get( 'section-type' );
			var sectionSettings = sectionData.settings[ sectionType ];

			if ( sectionSettings ) {
				window.obspgb.overlay = new window.obspgb.overlays.configuration( {
					model: this.model,
					buttonLabel: builderSettings.updateGalleryLabel,
				}, sectionSettings );
				window.obspgb.overlay.open();
			}
		},
	} );

	var ItemView = obspgb.classes.SectionItemView.extend( {
		template: wp.template( 'ttfobspgb-section-gallery-item' ),

		events: _.extend( {}, obspgb.classes.SectionItemView.prototype.events, {
			'click .ttfobspgb-gallery-item-remove': 'onRemoveItemClick',
			'click .ttfobspgb-gallery-item-configure': 'onConfigureItemClick',
			'click .edit-content-link': 'onEditItemContentClick',
			'click .ttfobspgb-media-uploader-placeholder': 'onUploaderSlideClick'
		} ),

		afterRender: function() {
			obspgb.classes.SectionItemView.prototype.afterRender.apply( this, arguments );

			this.listenTo( this.model, 'change:background-image-url', this.onItemBackgroundChanged );
		},

		onRemoveItemClick: function( e ) {
			e.preventDefault();

			if ( ! confirm( 'Are you sure you want to trash this item permanently?' ) ) {
				return;
			}

			this.model.collection.remove( this.model );
		},

		onItemBackgroundChanged: function( itemModel ) {
			var $placeholder = $( '.ttfobspgb-media-uploader-placeholder', this.$el );
			var backgroundImageURL = itemModel.get( 'background-image-url' );

			$placeholder.css( 'background-image', 'url(' + backgroundImageURL + ')' );

			if ( '' !== backgroundImageURL ) {
				$placeholder.parent().addClass( 'ttfobspgb-has-image-set' );
			} else {
				$placeholder.parent().removeClass( 'ttfobspgb-has-image-set' );
			}
		},

		onEditItemContentClick: function( e ) {
			e.preventDefault();

			window.obspgb.overlay = new window.obspgb.overlays.content( {
				model: this.model,
				field: 'description',
				buttonLabel: 'Update item'
			} );
			window.obspgb.overlay.open();

			var backgroundColor = this.model.parentModel.get( 'background-color' );
			backgroundColor = '' !== backgroundColor ? backgroundColor : 'transparent';
			window.obspgb.overlay.setStyle( { backgroundColor: backgroundColor } );
		},

		onUploaderSlideClick: function( e ) {
			e.preventDefault();

			window.obspgb.media = new window.obspgb.overlays.media( {
				model: this.model,
				field: 'background-image',
				type: 'image',
				title: $( e.target ).data( 'title' )
			} );

			window.obspgb.media.open();
		},

		onConfigureItemClick: function( e ) {
			e.preventDefault();

			var sectionType = this.model.get( 'section-type' );
			var sectionSettings = sectionData.settings[ sectionType ];

			if ( sectionSettings ) {
				window.obspgb.overlay = new window.obspgb.overlays.configuration( {
					model: this.model,
					title: 'Configure item',
					buttonLabel: 'Update item',
				}, sectionSettings );
				window.obspgb.overlay.open();
			}
		},

	} );

	obspgb.factory.model = _.wrap( obspgb.factory.model, function( func, attrs, BaseClass ) {
		switch ( attrs[ 'section-type' ] ) {
			case 'gallery': BaseClass = Model; break;
			case 'gallery-item': BaseClass = ItemModel; break;
		}

		return func( attrs, BaseClass );
	} );

	obspgb.factory.view = _.wrap( obspgb.factory.view, function( func, options, BaseClass ) {
		switch ( options.model.get( 'section-type' ) ) {
			case 'gallery': BaseClass = View; break;
			case 'gallery-item': BaseClass = ItemView; break;
		}

		return func( options, BaseClass );
	} );

} ) ( jQuery, _, Backbone, ttfobspgbBuilderSettings, ttfObspgbSections );