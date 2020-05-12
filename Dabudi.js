let Dabudi = {
	propget: function(pos, prop, item) {
		if (item) {
			if (typeof(item[prop]) != 'undefined') return item[prop];
			if (item.more && typeof(item.more[prop]) != 'undefined') return item.more[prop];
		}
		if (typeof(pos[prop]) != 'undefined') return pos[prop];
		if (pos.more && typeof(pos.more[prop]) != 'undefined') return pos.more[prop];
	}
}

export {Dabudi}